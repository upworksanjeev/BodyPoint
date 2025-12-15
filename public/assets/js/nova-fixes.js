;(function () {
  var interceptorKey = '__bp_nova_fix_interceptor_installed__';

  function installInterceptor() {
    try {
      if (typeof window === 'undefined' || typeof window.Nova === 'undefined') {
        return false;
      }
      if (window[interceptorKey]) return true;

      var originalRequest = window.Nova.request;
      if (typeof originalRequest !== 'function') return false;

      function ensureInterceptors(client) {
        if (!client || !client.interceptors || client.__bp_guard_installed) return;
        // Request interceptor: ensure draftId exists for field-attachment uploads
        try {
          client.interceptors.request.use(function (config) {
            try {
              var url = (config && config.url) || '';
              var data = config && config.data;
              var isFormData = (typeof FormData !== 'undefined') && data instanceof FormData;
              if (url.indexOf('/field-attachment/') !== -1 && isFormData) {
                var currentDraft = data.get('draftId');
                if (!currentDraft || currentDraft === 'undefined' || currentDraft === 'null') {
                  var newDraft = 'draft_' + Date.now() + '_' + Math.random().toString(36).slice(2, 10);
                  data.set('draftId', newDraft);
                }
              }
            } catch (_) {}
            return config;
          });
        } catch (_) {}
        client.interceptors.response.use(
          function (response) {
            try {
              var url = (response && response.config && response.config.url) || '';
              if (url.indexOf('/field-attachment/') !== -1) {
                var data = response.data;
                // Vendor expects a JSON string and calls JSON.parse on it.
                // Preserve a string payload to avoid throwing inside vendor code.
                if (data && typeof data.url === 'string') {
                  response.data = data.url; // keep as string
                } else if (typeof data === 'object') {
                  // As a fallback, stringify objects
                  try { response.data = JSON.stringify(data); } catch (_) {}
                }
              }
            } catch (_) {}
            return response;
          },
          function (error) {
            if (!error || typeof error !== 'object') {
              error = { response: { status: 0, data: { message: 'Upload failed' } } };
            } else if (!error.response) {
              error.response = { status: 0, data: { message: 'Upload failed' } };
            } else if (!error.response.data) {
              error.response.data = { message: 'Upload failed' };
            }
            return Promise.reject(error);
          }
        );
        client.__bp_guard_installed = true;
      }

      // Wrap Nova.request so every created client is guarded
      if (!originalRequest.__bp_wrapped) {
        window.Nova.request = function () {
          var client = originalRequest.apply(this, arguments);
          try { ensureInterceptors(client); } catch (_) {}
          return client;
        };
        window.Nova.request.__bp_wrapped = true;
      }

      // Also guard an immediate client, if any
      try { ensureInterceptors(originalRequest()); } catch (_) {}

      // Guard global axios (if vendor uses it directly)
      try {
        var ax = window.axios || (window.Nova && window.Nova.axios);
        if (ax) {
          ensureInterceptors(ax);
          if (typeof ax.create === 'function' && !ax.__bp_create_wrapped) {
            var originalCreate = ax.create.bind(ax);
            ax.create = function () {
              var client = originalCreate.apply(this, arguments);
              try { ensureInterceptors(client); } catch (_) {}
              return client;
            };
            ax.__bp_create_wrapped = true;
          }
        }
      } catch (_) {}

      // Patch the image-gallery-field Vue component catch path to guard non-Axios errors
      try {
        var tryPatchComponent = function () {
          try {
            var Vue = window.Vue || (window.Nova && window.Nova.Vue);
            if (!Vue || !Vue.options || !Vue.options.components) return false;
            var comp = Vue.options.components['image-gallery-field'];
            if (!comp || !comp.options || !comp.options.methods) return false;
            var methods = comp.options.methods;
            var orig = methods.validateImage;
            if (typeof orig !== 'function' || methods.__bp_wrapped_validateImage) return true;
            methods.validateImage = function () {
              try {
                var result = orig.apply(this, arguments);
                if (result && typeof result.then === 'function') {
                  return result.catch(function (err) {
                    if (!err || typeof err !== 'object' || !err.response) {
                      err = { response: { status: 0, data: { message: 'Upload failed' } }, originalError: err };
                    }
                    return Promise.reject(err);
                  });
                }
                return result;
              } catch (err) {
                if (!err || typeof err !== 'object' || !err.response) {
                  err = { response: { status: 0, data: { message: 'Upload failed' } }, originalError: err };
                }
                return Promise.reject(err);
              }
            };
            methods.__bp_wrapped_validateImage = true;
            return true;
          } catch (_) {
            return false;
          }
        };
        if (!tryPatchComponent()) {
          var tries = 0;
          var max = 200;
          var iv = setInterval(function () {
            tries++;
            if (tryPatchComponent() || tries >= max) clearInterval(iv);
          }, 50);
        }
      } catch (_) {}

      window[interceptorKey] = true;
      return true;
    } catch (e) {
      return false;
    }
  }

  // Attempt immediate install
  if (!installInterceptor()) {
    // If Nova isn't ready yet, wait for it
    var attempts = 0;
    var maxAttempts = 200; // ~10s at 50ms
    var interval = setInterval(function () {
      attempts++;
      if (installInterceptor() || attempts >= maxAttempts) {
        clearInterval(interval);
      }
    }, 50);
  }
})();



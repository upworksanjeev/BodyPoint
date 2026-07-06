;(function () {
  var emergencyToggleKey = '__bp_emergency_toggle_enhanced__';

  function installEmergencyToggle() {
    try {
      if (typeof document === 'undefined' || window[emergencyToggleKey]) return false;

      var styleId = 'bp-emergency-toggle-style';
      if (!document.getElementById(styleId)) {
        var style = document.createElement('style');
        style.id = styleId;
        style.textContent = ''
          + '[id^="is_enabled-"][id$="-boolean-field"] span.inline-flex {'
          + '  width: 46px !important;'
          + '  height: 24px !important;'
          + '  border-radius: 999px;'
          + '  background: #d1d5db !important;'
          + '  position: relative;'
          + '  cursor: pointer;'
          + '  transition: background 180ms ease;'
          + '  display: inline-flex !important;'
          + '  align-items: center !important;'
          + '  justify-content: flex-start !important;'
          + '  padding: 3px !important;'
          + '  border: 0 !important;'
          + '}'
          + '[id^="is_enabled-"][id$="-boolean-field"] span.inline-flex::before {'
          + '  content: "";'
          + '  position: absolute;'
          + '  left: 3px;'
          + '  top: 3px;'
          + '  width: 18px;'
          + '  height: 18px;'
          + '  border-radius: 50%;'
          + '  background: #fff;'
          + '  box-shadow: 0 1px 2px rgba(0,0,0,.2);'
          + '  transition: transform 180ms ease;'
          + '  display: block;'
          + '  pointer-events: none;'
          + '}'
          + '[id^="is_enabled-"][id$="-boolean-field"] span.inline-flex svg {'
          + '  display: none !important;'
          + '}'
          + '[id^="is_enabled-"][id$="-boolean-field"][data-state="checked"] span.inline-flex {'
          + '  background: #22c55e !important;'
          + '}'
          + '[id^="is_enabled-"][id$="-boolean-field"][data-state="checked"] span.inline-flex::before {'
          + '  transform: translateX(22px);'
          + '}';
        document.head.appendChild(style);
      }

      var enhance = function () {
        var control = document.querySelector('[id^="is_enabled-"][id$="-boolean-field"] span.inline-flex');
        if (!control) return;
        control.setAttribute('data-bp-toggle', '1');
      };

      enhance();
      var observer = new MutationObserver(enhance);
      observer.observe(document.body, { childList: true, subtree: true });
      window[emergencyToggleKey] = true;
      return true;
    } catch (_) {
      return false;
    }
  }

  if (!installEmergencyToggle()) {
    var attempts = 0;
    var maxAttempts = 200;
    var interval = setInterval(function () {
      attempts++;
      if (installEmergencyToggle() || attempts >= maxAttempts) {
        clearInterval(interval);
      }
    }, 50);
  }
})();

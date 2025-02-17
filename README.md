# Bodypoint: Enhancing Mobility with Technology

At Bodypoint, we work every day to better understand the capabilities and aspirations of people who use wheelchairs. As we imagine, design, and manufacture our products, we strive to bridge the gap between the hard and the soft, the inanimate and the living, to create a better connection between wheelchairs and people.

## 🚀 Project Overview

This repository contains the deployment automation setup for Bodypoint’s Laravel-based application, ensuring seamless and efficient deployments to AWS EC2 using GitHub Actions. Our goal is to streamline updates, improve reliability, and maintain a high level of security.

## 📌 Features

-   **Automated Deployment**: Deploys to AWS EC2 on `main` and `development` branches.
-   **Secure Authentication**: Uses GitHub Actions secrets for SSH-based deployment.
-   **Efficient Dependency Management**: Automates Composer and NPM package installations.
-   **Database Management**: Runs Laravel migrations and optimizations automatically.
-   **Code Quality Assurance**: PHP syntax validation and frontend build automation.

---

## 📘 Deployment Setup Guide

### 🔹 Staging Deployment (`development` branch)

This process deploys the `development` branch to the staging environment on AWS EC2.

#### **Setup Instructions:**

1. Push code to the `development` branch.
2. Ensure the necessary GitHub Actions secrets are configured:
    - `SSH_STAGING_HOST`
    - `SSH_STAGING_KEY`
    - `SSH_STAGING_USERNAME`
3. The workflow will:
    - Checkout the latest code.
    - Upload code to AWS EC2.
    - Install dependencies and execute Laravel commands.

---

### 🔹 Production Deployment (`main` branch)

The `main` branch deployment process updates the production environment on AWS EC2.

#### **Setup Instructions:**

1. Push code to the `main` branch.
2. Configure the required GitHub Actions secrets:
    - `SSH_HOST`
    - `SSH_KEY`
    - `SSH_USERNAME`
3. The workflow will:
    - Pull the latest code.
    - Install dependencies and execute necessary Laravel commands.

---

## 🛠 PHP Syntax Check & Build Workflow

To ensure high-quality code, this workflow validates and builds the application before deployment.

#### **Setup Instructions:**

1. Runs automatically on `push` and `pull_request` events for `development` and `main` branches.
2. Dependencies for PHP and Node.js must be installed.
3. The workflow will:
    - Validate PHP syntax.
    - Install Node.js dependencies.
    - Run the frontend build process.

---

## 🔑 Secrets Configuration

To enable deployment automation, configure the following GitHub Actions secrets:

-   **For Staging Deployment:**

    -   `SSH_STAGING_HOST`
    -   `SSH_STAGING_KEY`
    -   `SSH_STAGING_USERNAME`

-   **For Production Deployment:**
    -   `SSH_HOST`
    -   `SSH_KEY`
    -   `SSH_USERNAME`

---

## 🎯 How to Use

1. **Push code** to `development` branch for staging deployment.
2. **Push code** to `main` branch for production deployment.
3. GitHub Actions will **validate code**, **build assets**, and **deploy automatically**.
4. The latest code is deployed securely to AWS EC2, ensuring a seamless experience.

---

## 🏗 Tech Stack

-   **Laravel** (Backend Framework)
-   **MySQL** (Database)
-   **AWS EC2** (Hosting)
-   **GitHub Actions** (CI/CD Automation)
-   **Composer & NPM** (Package Managers)
-   **PHP 8.1 & Node.js 18** (Runtime Environments)

---

## 🤝 Contribution & Support

At Bodypoint, we are committed to improving the mobility and independence of wheelchair users. If you’d like to contribute, raise an issue, or need support, feel free to reach out!

🚀 Together, we build a better connection between wheelchairs and people.

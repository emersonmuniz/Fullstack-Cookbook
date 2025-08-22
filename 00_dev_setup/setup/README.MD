# Setup Instructions

This guide outlines the tools and steps needed to set up my development environment for macOS, Linux, and Windows. The setup supports coding and studying across backend, frontend, mobile, AI, and DevOps.

## Folder Structure

```
my-learning-lab/
└── 00_dev_setup/
    ├── dockers/
    │   └── (Docker Compose files and configurations)
    └── setup/
        ├── macOS/
        │   └── README.md
        ├── Linux/
        │   └── README.md
        └── Windows/
            └── README.md
```

> **Note:** For database in Windows and macOS I like to use [DBngin](https://dbngin.com/), easy to use.

## General Prerequisites
- **Git**: For cloning and managing the repository.
- **Code Editor**: VS Code (I use) or any editor like PyCharm, IntelliJ.
- **Terminal**: Use built-in terminals.
- **Docker**: For containerized environments (see `00_dev_setup/dockers/` for configs).

## macOS Setup

### Tools to Install
- **Homebrew** (package manager): `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
- **Git**: `brew install git`
- **Python 3.10+**: `brew install python`
- **Node.js 18+**: `brew install node`
- **PHP 8.1+**: `brew install php`
- **Composer** (PHP dependency manager): `brew install composer`
- **Flutter**: `brew install --cask flutter`
- **Docker Desktop**: Download from [Docker Hub](https://www.docker.com/products/docker-desktop/)
- **VS Code**: `brew install --cask visual-studio-code`

### Steps
1. Clone the repo: `git clone https://github.com/emersonmuniz/my-learning-lab.git`
2. Navigate to a project folder (e.g., `cd 01_backend/django`).
3. Install dependencies (e.g., `pip install -r requirements.txt` for Python or `npm install` for Vue).
4. For Docker-based projects, navigate to `00_dev_setup/dockers/` and run `docker-compose up`.
5. Verify Flutter setup: `flutter doctor`

## Linux Setup

### Tools to Install (Ubuntu/Debian-based)
- **Git**: `sudo apt update && sudo apt install git`
- **Python 3.10+**: `sudo apt install python3 python3-pip`
- **Node.js 18+**: `curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash - && sudo apt install -y nodejs`
- **PHP 8.1+**: `sudo apt install php php-cli php-fpm php-mysql`
- **Composer**: `sudo apt install composer`
- **Flutter**: Download from [Flutter SDK](https://flutter.dev/docs/get-started/install/linux), extract to `/opt/flutter`, and add to PATH: `export PATH="$PATH:/opt/flutter/bin"`
- **Docker**: `sudo apt install docker.io docker-compose`
- **VS Code**: `sudo snap install --classic code`

### Steps
1. Clone the repo: `git clone https://github.com/emersonmuniz/my-learning-lab.git`
2. Navigate to a project folder (e.g., `cd 01_backend/laravel`).
3. Install dependencies (e.g., `composer install` for Laravel or `pip3 install -r requirements.txt` for Django).
4. For Docker, go to `00_dev_setup/dockers/` and run `sudo docker-compose up`.
5. Verify Flutter setup: `flutter doctor`

## Windows Setup

### Tools to Install
- **WSL2** (recommended for Linux-like environment): Enable via `wsl --install` in PowerShell (admin mode).
- **Git**: Download from [Git SCM](https://git-scm.com/download/win)
- **Python 3.10+**: Download from [Python.org](https://www.python.org/downloads/)
- **Node.js 18+**: Download from [Node.js](https://nodejs.org/en/download/)
- **PHP 8.1+**: Download from [PHP.net](https://windows.php.net/download/)
- **Composer**: Download from [getcomposer.org](https://getcomposer.org/download/)
- **Flutter**: Download from [Flutter SDK](https://flutter.dev/docs/get-started/install/windows), extract to `C:\flutter`, and add to PATH.
- **Docker Desktop**: Download from [Docker Hub](https://www.docker.com/products/docker-desktop/), enable WSL2 backend.
- **VS Code**: Download from [code.visualstudio.com](https://code.visualstudio.com/)

### Steps
1. Open WSL2 terminal (or PowerShell) and clone the repo: `git clone https://github.com/emersonmuniz/my-learning-lab.git`
2. Navigate to a project folder (e.g., `cd 01_backend/python`).
3. Install dependencies (e.g., `pip install -r requirements.txt` or `npm install`).
4. For Docker, go to `00_dev_setup/dockers/` and run `docker-compose up` (use WSL2 for better performance).
5. Verify Flutter setup: `flutter doctor`

## Notes
- **Docker**: Centralized Docker configs are in `00_dev_setup/dockers/`. Use these for consistent environments across OSes.
- **Space Estimate**: Expect 4–7 GB for Docker images, containers, and project files.
- **AI Tools**: For TensorFlow/PyTorch, install via `pip install tensorflow pytorch` after Python setup.
- **Troubleshooting**: Check `flutter doctor`, `docker --version`, or `node --version` to verify installations.
- **Updates**: Keep tools updated (e.g., `brew update`, `apt update`, or `winget upgrade`).
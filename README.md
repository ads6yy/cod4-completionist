# COD4 Completionist

A web application dedicated to **Call of Duty 4: Modern Warfare (2007)**. This project serves as a Wiki and a progress tracker for players to manage challenges, weapon camos, and game completion.

**Blog Post:** [adsy.dev/node/20](https://adsy.dev/node/20)

![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)

## 📖 About

As a fan of the Call of Duty license, I wanted to build a tool to track progress for the classic COD4: Modern Warfare. Inspired by the visual tracking concepts of [Emil Carlsson](https://github.com/carlssonemil/), this project adds a robust backend to handle user persistence and data management.

This project was also built as a technical playground to experiment with **Symfony 7.1**, **AssetMapper**, and data management via Excel imports.

### Key Features
* **Wiki Database:** Detailed data on weapons, maps, and accessories.
* **Progress Tracking:** Users can create an account and track completed challenges and unlocked camos.
* **Interactive UI:** AJAX-driven updates for seamless challenge toggling (visual cues for completion/deletion).
* **Excel Data Source:** Game data is managed via Excel spreadsheets and imported using `phpoffice/phpspreadsheet`.

## 🛠️ Tech Stack

**Infrastructure**
* **Docker:** Nginx, PHP 8.3, MySQL 8.

**Backend**
* **Framework:** Symfony 7.1
* **Language:** PHP 8.3
* **Database:** MySQL 8
* **Libraries:**
    * `phpoffice/phpspreadsheet` (Data import)
    * `karser/karser-recaptcha3-bundle` (Security)

**Frontend**
* **Asset Management:** Symfony AssetMapper
* **CSS Framework:** Bootstrap 5.3
* **Templating:** Twig

# 🚛 Smart Waste Management System with Real-Time Tracking

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## 🌟 Overview
This is a modern **Smart Waste Management System** built with **Laravel 12**. The application focuses on optimizing garbage collection routes using Google Maps and providing real-time vehicle tracking for residents and admins.

## 🚀 Key Featurs

* **Real-Time Driver Tracking:** Live tracking of waste collection vehicles using **Laravel Reverb (WebSockets)**. No page refresh is required to see the driver move.
* **Route Optimization:** Automatically calculates the most fuel-efficient route using **Google Directions API** for pending pickup requests.
* **Interactive Pickup Requests:** Residents can pin their location directly on a map to submit waste collection requests.
* **Admin Dashboard:** Comprehensive analytics dashboard using **Chart.js** to monitor pending, assigned, and completed requests.
* **Authentication:** Secure login and registration system powered by **Laravel Breeze**.

## 🛠️ Tech Stack

* **Backend:** PHP 8.2+ / Laravel 12
* **Real-time:** Laravel Reverb (WebSocket Server)
* **Frontend:** Tailwind CSS / Alpine.js (via Laravel Breeze)
* **Maps:** Google Maps JavaScript API / Directions API
* **Database:** MySQL / SQLite

## ⚙️ Installation & Setup

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/sandun200209/smart-waste-management.git](https://github.com/sandun200209/smart-waste-management.git)
    cd smart-waste-management
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup:**
    * Rename `.env.example` to `.env`.
    * Set your database credentials.
    * Add your **Google Maps API Key**: `Maps_API_KEY=your_api_key_here`

4.  **Run Migrations:**
    ```bash
    php artisan migrate
    ```

5.  **Compile Assets:**
    ```bash
    npm run build
    ```

6.  **Start the Application:**
    You need to run three terminals:
    * `php artisan serve` (Web Server)
    * `php artisan reverb:start` (WebSocket Server)
    * `npm run dev` (Vite Server)

## 📸 Screenshots
*(You can add your screenshots here later)*

## 📄 License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

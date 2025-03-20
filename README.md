# Sports Arena Booking System

## Overview
This project is a **sports arena booking system** built using **Laravel**. It allows users to reserve time slots for different arenas while ensuring proper concurrency handling. It includes an **admin panel** for managing arenas and a **secure booking mechanism** to prevent double reservations.

## Features
- **Admin Authentication:** Admins can log in to manage arenas and time slots.
- **Arena Management:** Admins can create arenas with configurable time slots.
- **Time Slot Configuration:** Time slots range from **08:00 AM to 11:00 PM**, with customizable durations (e.g., 30 minutes, 1 hour).
- **Secure Booking System:**
  - Users can book available time slots.
  - If a booking is not confirmed within **10 minutes**, it is automatically released.
  - Prevents double booking through **transactions and middleware**.
- **Concurrency Handling:** Ensures that no two users can book the same slot simultaneously.

## Project Structure
```
├── app/
│   ├── Domains/
│   │   ├── Arenas/         # Arena management
│   │   ├── Bookings/       # Booking logic & transactions
│   │   ├── User/           # User authentication & admin roles
│   ├── Http/
│   │   ├── Controllers/    # API & Web controllers
│   │   ├── Middleware/     # Middleware for request validation
│   ├── Services/           # Business logic services
├── database/
│   ├── factories/          # Factories for test data
│   ├── migrations/         # Database migrations
│   ├── seeders/            # Initial database seeders
├── routes/
│   ├── api.php            # API routes
│   ├── web.php            # Web routes
├── tests/
│   ├── Feature/           # Feature tests
│   ├── Unit/              # Unit tests
```

## Technical Decisions
### **1. Authentication System**
- Implemented **Laravel authentication** for admins.
- Used **middleware** to restrict access to admin functionalities.

### **2. Time Slot Configuration**
- Time slots are **automatically generated** from **08:00 AM to 11:00 PM**.
- Each slot follows a predefined **duration (30 minutes, 1 hour, etc.)**.
- Implemented **validation checks** to ensure proper slot assignments.

### **3. Secure Booking Mechanism**
- Used **database transactions** (`DB::beginTransaction()`, `try/catch`) to prevent inconsistencies.
- Implemented **middleware** to validate requests and prevent unauthorized access.
- Added a **job (queue system)** to release unconfirmed bookings after **10 minutes**.

## Installation
### **1. Clone the Repository**
```sh
git clone https://github.com/your-username/sports-arena-booking.git
cd sports-arena-booking
```

### **2. Install Dependencies**
```sh
composer install
npm install
```

### **3. Set Up the Environment**
```sh
cp .env.example .env
php artisan key:generate
```
Update `.env` file with your database credentials.

### **4. Run Migrations & Seed Database**
```sh
php artisan migrate --seed
```

### **5. Start the Application**
```sh
php artisan serve
```

## API Endpoints
| Method | Endpoint        | Description                      |
|--------|----------------|----------------------------------|
| POST   | `/api/login`   | Login as admin                  |
| POST   | `/api/arenas`  | Create a new arena              |
| GET    | `/api/arenas`  | List all arenas                 |
| POST   | `/api/bookings`| Reserve a time slot             |
| GET    | `/api/bookings`| View all bookings               |

## Running Tests
```sh
php artisan test
```

## Contributing
Feel free to fork the repository and submit pull requests with improvements.

## License
This project is open-source and available under the [MIT License](LICENSE).


# Website Planner Event

Un sitio web para planificar eventos sociales, especialmente baby showers, desarrollado con Laravel 12.

## Descripción

Esta aplicación permite a los usuarios planificar eventos de manera organizada, gestionando invitados, regalos y configuraciones personales. Incluye un sistema de base de datos para almacenar información de usuarios, eventos, invitados y regalos, facilitando la coordinación y evitando problemas comunes en la organización de eventos.

## Propósito del Proyecto

### Qué Hace
- **Planificación de Eventos**: Permite crear y gestionar eventos sociales como baby showers.
- **Gestión de Invitados**: Envío de invitaciones, seguimiento de confirmaciones y control de asistencia.
- **Gestión de Regalos**: Registro de regalos deseados, sugerencias para invitados y seguimiento de entregas para evitar duplicados o regalos innecesarios.
- **Configuraciones Personales**: Opciones para personalizar la experiencia del usuario.

### Por Qué Existe
La organización de eventos sociales, especialmente baby showers, enfrenta dificultades técnicas que afectan a organizadores e invitados. La falta de un sistema estructurado provoca regalos poco útiles, gestión informal de invitados y caos general.

### Problema que Resuelve
#### Descripción del Problema Técnico
- **Regalos**: Invitados entregan obsequios innecesarios, repetidos o poco prácticos. Los futuros padres reciben artículos que no se ajustan a sus necesidades.
- **Gestión de Invitados**: Invitaciones enviadas por canales informales (mensajes, llamadas, redes sociales), con escasa trazabilidad y evidencia de confirmación. Ausencia de invitados por falta de claridad.
- **Impacto**:
  - **Técnico**: Falta de trazabilidad en confirmaciones y regalos; información dispersa en múltiples canales.
  - **Operacional**: Desorganización en planificación, aumento de carga de trabajo y riesgo de errores; ausencia de invitados.
  - **Económico**: Gastos en regalos inútiles; costos adicionales en logística y compras de último minuto.

#### Importancia de Resolverlo
- **Mejora la Experiencia**: Reduce frustración para organizadores e invitados.
- **Eficiencia**: Centraliza información, facilita coordinación.
- **Ahorro**: Evita gastos innecesarios en regalos y logística.

## Instalación

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js y npm
- Base de datos (MySQL, PostgreSQL, etc.)
- Laravel 12

### Pasos
1. **Clona el Repositorio**:
   ```
   git clone https://github.com/frederickiribarren-dev/website-planner-event.git
   cd website-planner-event
   ```

2. **Instala Dependencias de PHP**:
   ```
   composer install
   ```

3. **Instala Dependencias de JavaScript**:
   ```
   npm install
   ```

4. **Configura el Entorno**:
   - Copia `.env.example` a `.env`:
     ```
     cp .env.example .env
     ```
   - Edita `.env` con tus credenciales de base de datos:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=website_planner_event
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```

5. **Genera Clave de Aplicación**:
   ```
   php artisan key:generate
   ```

6. **Ejecuta Migraciones**:
   ```
   php artisan migrate
   ```

7. **Compila Assets**:
   ```
   npm run build
   ```

8. **Inicia el Servidor**:
   ```
   php artisan serve
   ```
   Accede en `http://localhost:8000`.

## Uso

- Regístrate como usuario.
- Crea un evento desde el panel.
- Agrega invitados y especifica regalos deseados.
- Envía invitaciones y sigue confirmaciones.
- Gestiona regalos para evitar duplicados.

## Estructura del Proyecto

### Carpetas Principales
- `app/`: Código de la aplicación (Modelos, Controladores, etc.).
- `database/`: Migraciones, factories y seeders.
- `public/`: Archivos públicos (CSS, JS, imágenes).
- `resources/`: Vistas, assets no compilados.
- `routes/`: Definición de rutas.
- `tests/`: Pruebas unitarias y de funcionalidad.

### Archivos Principales
- `composer.json`: Dependencias PHP.
- `package.json`: Dependencias JS.
- `artisan`: Comando CLI de Laravel.
- `vite.config.js`: Configuración de Vite.

### Ejemplos de Configuración
- `.env`: Variables de entorno (base de datos, mail, etc.).
- `config/app.php`: Configuración general de la app.

## Contribución

### Normas para Enviar Cambios
- Crea una rama para tu feature: `git checkout -b feature/nueva-funcionalidad`.
- Realiza commits descriptivos.
- Envía un Pull Request con descripción detallada.

### Estándares de Código
- Sigue PSR-12 para PHP.
- Usa ESLint para JS.
- Ejecuta `php artisan pint` para formateo.

### Reportar Errores
- Abre un issue en GitHub con descripción, pasos para reproducir y entorno.

## Información Adicional

### Licencia
Este proyecto está bajo la Licencia MIT.

### Créditos
- Desarrollado por:
  - Frederick Iribarren Barraza
  - Camila Meyer Zúñiga
  - Franco Zúñiga Martínez
- Basado en Laravel Framework.

### Enlaces
- [Documentación de Laravel](https://laravel.com/docs)
- [Wiki del Proyecto](https://github.com/frederickiribarren-dev/website-planner-event/wiki) (si aplica)

---

# Website Planner Event

A website for planning social events, especially baby showers, built with Laravel 12.

## Description

This application allows users to plan events in an organized manner, managing guests, gifts, and personal configurations. It includes a database system to store information about users, events, guests, and gifts, facilitating coordination and avoiding common problems in event organization.

## Project Purpose

### What It Does
- **Event Planning**: Allows creating and managing social events like baby showers.
- **Guest Management**: Sending invitations, tracking confirmations, and controlling attendance.
- **Gift Management**: Recording desired gifts, suggestions for guests, and tracking deliveries to avoid duplicates or unnecessary gifts.
- **Personal Configurations**: Options to customize the user experience.

### Why It Exists
The organization of social events, especially baby showers, faces technical difficulties that affect organizers and guests. The lack of a structured system causes useless gifts, informal guest management, and general chaos.

### Problem It Solves
#### Technical Problem Description
- **Gifts**: Guests deliver unnecessary, repeated, or impractical gifts. Future parents receive items that do not fit their real needs.
- **Guest Management**: Invitations sent through informal channels (messages, calls, social networks), with scarce traceability and evidence of confirmation. Absence of guests due to lack of clarity.
- **Impact**:
  - **Technical**: Lack of traceability in confirmations and gifts; information scattered across multiple channels.
  - **Operational**: Disorganization in planning, increased workload and error risk; absence of guests.
  - **Economic**: Expenses on useless gifts; additional costs in logistics and last-minute purchases.

#### Importance of Solving It
- **Improves Experience**: Reduces frustration for organizers and guests.
- **Efficiency**: Centralizes information, facilitates coordination.
- **Savings**: Avoids unnecessary expenses on gifts and logistics.

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- Database (MySQL, PostgreSQL, etc.)
- Laravel 12

### Steps
1. **Clone the Repository**:
   ```
   git clone https://github.com/frederickiribarren-dev/website-planner-event.git
   cd website-planner-event
   ```

2. **Install PHP Dependencies**:
   ```
   composer install
   ```

3. **Install JavaScript Dependencies**:
   ```
   npm install
   ```

4. **Configure the Environment**:
   - Copy `.env.example` to `.env`:
     ```
     cp .env.example .env
     ```
   - Edit `.env` with your database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=website_planner_event
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Generate Application Key**:
   ```
   php artisan key:generate
   ```

6. **Run Migrations**:
   ```
   php artisan migrate
   ```

7. **Compile Assets**:
   ```
   npm run build
   ```

8. **Start the Server**:
   ```
   php artisan serve
   ```
   Access at `http://localhost:8000`.

## Usage

- Register as a user.
- Create an event from the dashboard.
- Add guests and specify desired gifts.
- Send invitations and track confirmations.
- Manage gifts to avoid duplicates.

## Project Structure

### Main Folders
- `app/`: Application code (Models, Controllers, etc.).
- `database/`: Migrations, factories, and seeders.
- `public/`: Public files (CSS, JS, images).
- `resources/`: Views, uncompiled assets.
- `routes/`: Route definitions.
- `tests/`: Unit and feature tests.

### Main Files
- `composer.json`: PHP dependencies.
- `package.json`: JS dependencies.
- `artisan`: Laravel CLI command.
- `vite.config.js`: Vite configuration.

### Configuration Examples
- `.env`: Environment variables (database, mail, etc.).
- `config/app.php`: General app configuration.

## Contribution

### Guidelines for Submitting Changes
- Create a branch for your feature: `git checkout -b feature/new-functionality`.
- Make descriptive commits.
- Send a Pull Request with detailed description.

### Code Standards
- Follow PSR-12 for PHP.
- Use ESLint for JS.
- Run `php artisan pint` for formatting.

### Reporting Bugs
- Open an issue on GitHub with description, reproduction steps, and environment.

## Additional Information

### License
This project is under the MIT License.

### Credits
- Developed by:
  - Frederick Iribarren Barraza
  - Camila Meyer Zúñiga
  - Franco Zúñiga Martínez
- Based on Laravel Framework.

### Links
- [Laravel Documentation](https://laravel.com/docs)
- [Project Wiki](https://github.com/frederickiribarren-dev/website-planner-event/wiki) (if applicable)

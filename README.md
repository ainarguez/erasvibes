# 🌍 Erasvibes

Conecta con otros estudiantes Erasmus en tu misma ciudad, fechas y destino.

![Logo](public/img/logo.png)

---

## ❓ ¿Qué es Erasvibes?

**Erasvibes** es una plataforma web desarrollada con Laravel que permite a estudiantes del programa Erasmus encontrarse, comunicarse y crear comunidad en su ciudad de destino. Los usuarios pueden filtrar personas por fechas y lugares, añadir amigos y chatear en privado.

---

## 🎯 Objetivos del Proyecto

- Conectar a estudiantes Erasmus en base a fechas y lugares comunes.
- Fomentar la integración social y el acompañamiento en una nueva ciudad.
- Facilitar la búsqueda de alojamiento, universidades o eventos comunes.
- Ofrecer una plataforma segura, moderna y amigable.

---

## 🔍 Funcionalidades Principales

- Registro y autenticación de usuarios
- Filtro por fechas y lugar de destino
- Sistema de solicitudes y lista de amigos
- Chat privado entre usuarios conectados
- Vista del perfil propio y de otros estudiantes
- Panel de administrador para gestionar usuarios

---

## 🧰 Tecnologías Usadas

| Herramienta        | Propósito                        | Versión  |
|--------------------|----------------------------------|----------|
| Laravel            | Framework backend PHP            | 11.x     |
| PHP                | Lenguaje del servidor            | 8.3      |
| MySQL              | Base de datos relacional         | 8.0+     |
| Bootstrap          | Framework de diseño CSS          | 5.x      |
| Composer           | Gestión de dependencias PHP      | 2.x      |
| Node.js & npm      | Compilación de assets frontend   | 18.x     |
| Git & GitHub       | Control de versiones             | -        |

Compatible con Linux, macOS y Windows.

---

## ⚙️ Instalación del Proyecto

### Requisitos previos

- PHP >= 8.1
- Composer
- Node.js y npm
- MySQL
- Apache / Nginx
- Laravel CLI (`composer global require laravel/installer`)

### Pasos

```bash
git clone https://github.com/ainarguez/erasvibes.git
cd erasvibes
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link

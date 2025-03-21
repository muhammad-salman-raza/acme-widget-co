# Acme Widget Co Sales System

This repository contains a proof of concept for Acme Widget Co’s new sales system. It demonstrates:

- **Product Module:** Manages product data (code, name, price).
- **Basket Module:** Holds items, calculates subtotal and grand total, supports discounts and shipments.
- **Offer (Promotion) Module:** Adds discounts via easily replaceable plugins.
- **Delivery (Shipment) Module:** Manages shipments, fees, and availability rules.
- **AcmeSalesService (Aggregator):** Ties everything together so you can simply add products by code and get the final total.

## Table of Contents

1. [Project Overview](#project-overview)
2. [Installation & Setup](#installation--setup)
3. [Testing & Code Quality](#testing--code-quality)
4. [Modular Architecture](#modular-architecture)
    - [Adding a New Offer](#adding-a-new-offer)
    - [Adding a New Shipment Method](#adding-a-new-shipment-method)

---

## Project Overview

**Goal:** Provide a system where customers add products by code, receive special offers, and pay a shipping fee that changes based on the order total.

**Key Features:**

- **Buy One Red Widget, Get Second Half Price** special offer.
- **Delivery Fees** that adjust with thresholds (e.g., under \$50 => \$4.95).
- **Final Total** includes product prices, offers (discounts), and shipment fees.

---

## Installation & Setup

This project uses Docker, Docker Compose, and Composer. The **Makefile** provides convenient targets to build, install dependencies, run tests, etc.

1. **Clone the Repo:**
   ```bash
   git clone https://github.com/muhammad-salman-raza/acme-widget-co.git
   cd acme-widget-co

2. **Build the Docker Image:**
   ```bash
   make build-dev

## Testing & Code Quality
A suite of PHPUnit tests validates functionality. PHPStan and PHP CodeSniffer maintain code quality and style:

1. **Run All Tests:**
   ```bash
   make test

2. **Static Analysis (PHPStan):**
   ```bash
   make phpstan

3. **Code Sniffer (PSR-12):**
   ```bash
   make phpcs

4. **Auto-Fix Code Styl:**
   ```bash
   make phpcbf


## Modular Architecture

The code is split into modules, each with a **Module** file for dependency injection (DI) definitions and clearly defined interfaces. The main modules are:

1. **Product Module**
    - **ProductServiceInterface**: Fetches product details (e.g., by product code).
    - A typical implementation might return a `ProductInterface` with code, name, and a Money price.

2. **Basket Module**
    - **Basket** entity: Stores items, discounts, and shipment data.
    - **BasketServiceInterface**: Orchestrates adding products to the basket, setting discounts, assigning a shipment, and calculating totals (subtotal and grand total).

3. **Offer (Promotion) Module**
    - **OfferServiceInterface**: Calculates discounts by iterating over “offer plugins,” each of which implements an interface to return a `Discount`.
    - Example plugin: “Buy one red widget, get second half price.”

4. **Delivery (Shipment) Module**
    - **ShipmentInterface** objects: Each defines availability rules (`isAvailable()`) and fee calculation (`getPrice()`) for a shipment method.
    - **ShipmentServiceInterface**: Lists available shipments or fetches them by code, enabling the basket to pick the correct shipment method.

5. **AcmeSalesService (Aggregator)**
    - Ties everything together so users can simply `addProduct(code)` and then `getTotal()`.
    - Internally:
        - Looks up products via the Product module.
        - Updates the basket via the Basket module.
        - Applies discounts from the Offer module.
        - Calculates shipping fees from the Delivery module.

### Adding a New Offer

1. **Create a Plugin**: Implement the `OfferInterface` (or whichever contract your system uses).
2. Provide logic to return a `Discount` (e.g., a Money amount) based on the basket contents.
3. **Register** the new plugin in the Offer module’s `Module.php` or a similar config file so it’s injected into `OfferServiceInterface`.
4. The basket (or aggregator) will automatically apply this new discount.

### Adding a New Shipment Method

1. **Create a Class**: Implement `ShipmentInterface` (defines a code, name, `isAvailable()`, and `getPrice()`).
2. Optionally define new plugins for availability or price calculation if needed.
3. **Register** the new shipment in the Delivery module’s `Module.php` (or your DI config) so it’s discoverable by the `ShipmentServiceInterface`.
4. The basket can then choose this shipment method, either automatically (e.g., cheapest or first available) or based on user selection.

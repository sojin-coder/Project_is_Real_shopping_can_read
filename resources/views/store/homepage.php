<?php

require_once dirname(__DIR__, 3) . '/app/Helpers/functions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Tech Showcase</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Battambang:wght@300;400;700;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* ===== BACKGROUND GRADIENT ===== */
            --bg-gradient: linear-gradient(180deg, rgba(196, 34, 42, 1) 0%, rgba(59, 41, 105, 1) 75%);

            /* ===== SURFACE / GLASS ===== */
            --surface: rgba(255, 255, 255, 0.10);
            --surface-strong: rgba(255, 255, 255, 0.16);
            --surface-solid: #2a1f4a;
            --border-glass: rgba(255, 255, 255, 0.18);
            --border-strong: rgba(255, 255, 255, 0.30);

            /* ===== TEXT ===== */
            --text-main: #ffffff;
            --text-body: #f1e9f5;
            --text-muted: #d8c9e0;
            --text-soft: #b9a8c9;

            /* ===== ACCENTS ===== */
            --accent-gold: #fbbf24;
            --accent-rose: #fb7185;
            --accent-pink: #f472b6;
            --accent-sky: #38bdf8;
            --accent-emerald: #34d399;
            --accent-amber: #f59e0b;
            --accent-violet: #a78bfa;

            /* ===== SHADOWS ===== */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.20);
            --shadow-md: 0 6px 18px rgba(0, 0, 0, 0.30);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.40);
            --shadow-glow: 0 8px 24px rgba(251, 113, 133, 0.35);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Battambang', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            color: var(--text-body);
            transition: 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            line-height: 1.6;
        }

        ::selection {
            background: var(--accent-gold);
            color: #3b2969;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-family: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        /* ===== SCROLLBAR ===== */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--accent-gold);
        }

        /* ===== UTILITY ===== */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 640px) {
            .container {
                padding: 0 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .container {
                padding: 0 2rem;
            }
        }

        .hidden {
            display: none !important;
        }

        /* ===== GLASS EFFECTS ===== */
        .glass-nav {
            background: rgba(42, 22, 70, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            box-shadow: var(--shadow-sm);
        }

        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-md);
        }

        /* ===== ANNOUNCEMENT BAR ===== */
        .announcement-bar {
            background: rgba(0, 0, 0, 0.35);
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            text-align: center;
            font-weight: 500;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-glass);
        }

        @media (min-width: 640px) {
            .announcement-bar {
                font-size: 0.875rem;
            }
        }

        .announcement-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 0.5rem;
            gap: 0.5rem;
        }

        .announcement-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .announcement-left {
                gap: 1rem;
            }
        }

        .announcement-left .divider {
            color: var(--text-soft);
            opacity: 0.5;
        }

        .announcement-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .announcement-right a {
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--text-body);
        }

        .announcement-right a:hover {
            color: var(--accent-gold);
        }

        .text-emerald {
            color: var(--accent-emerald);
        }

        .text-sky {
            color: var(--accent-sky);
        }

        .text-blue {
            color: var(--accent-violet);
        }

        @media (max-width: 767px) {
            .hide-mobile {
                display: none;
            }
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 40;
            transition: all 0.3s;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 640px) {
            .navbar-inner {
                padding: 0 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .navbar-inner {
                padding: 0 2rem;
            }
        }

        .navbar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 5rem;
            gap: 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-rose));
            box-shadow: var(--shadow-glow);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .logo-icon i {
            color: #3b2969;
            font-size: 1.5rem;
        }

        .shop-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: 0.05em;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .logo-text {
                font-size: 1.5rem;
            }
        }

        .logo-badge {
            font-size: 0.75rem;
            background: rgba(251, 191, 36, 0.20);
            color: var(--accent-gold);
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            border: 1px solid rgba(251, 191, 36, 0.40);
            font-weight: 700;
        }

        .logo-sub {
            font-size: 0.625rem;
            color: var(--text-soft);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }

        /* Search Bar */
        .search-bar {
            flex: 1;
            max-width: 28rem;
            display: none;
        }

        @media (min-width: 768px) {
            .search-bar {
                display: block;
            }
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper input {
            width: 100%;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid var(--border-glass);
            border-radius: 0.75rem;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            font-size: 0.875rem;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s;
        }

        .search-wrapper input::placeholder {
            color: var(--text-soft);
        }

        .search-wrapper input:focus {
            background: rgba(0, 0, 0, 0.40);
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.20);
        }

        .search-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Nav Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .lang-switcher {
            display: flex;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 0.5rem;
            border: 1px solid var(--border-glass);
            padding: 0.125rem;
        }

        .lang-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .lang-btn:hover {
            color: var(--text-main);
        }

        .lang-btn.active {
            background: var(--accent-gold);
            color: #3b2969;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(251, 191, 36, 0.35);
        }

        .telegram-cta {
            display: none;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            background: var(--accent-sky);
            color: #0c1e2e;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.35);
        }

        .telegram-cta:hover {
            background: #7dd3fc;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(56, 189, 248, 0.50);
        }

        @media (min-width: 640px) {
            .telegram-cta {
                display: flex;
            }
        }

        /* Mobile Search */
        .mobile-search {
            padding-bottom: 0.75rem;
        }

        @media (min-width: 768px) {
            .mobile-search {
                display: none;
            }
        }

        .mobile-search .search-wrapper input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
        }

        .mobile-search .search-wrapper i {
            font-size: 0.75rem;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            overflow: hidden;
            padding: 3rem 0;
            background: transparent;
            border-bottom: 1px solid var(--border-glass);
        }

        @media (min-width: 1024px) {
            .hero {
                padding: 4rem 0;
            }
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 85% 15%, rgba(251, 191, 36, 0.15), transparent 55%),
                radial-gradient(circle at 10% 90%, rgba(251, 113, 133, 0.15), transparent 50%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: center;
        }

        @media (min-width: 1024px) {
            .hero-grid {
                grid-template-columns: 7fr 5fr;
            }
        }

        .hero-text {
            text-align: center;
        }

        @media (min-width: 1024px) {
            .hero-text {
                text-align: left;
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            background: rgba(251, 191, 36, 0.15);
            border: 1px solid rgba(251, 191, 36, 0.40);
            color: var(--accent-gold);
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(8px);
        }

        .hero-badge .dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 9999px;
            background: var(--accent-gold);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .hero-title {
            font-size: 1.875rem;
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.025em;
            line-height: 1.4;
            margin-top: 1.5rem;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        }

        @media (min-width: 640px) {
            .hero-title {
                font-size: 3rem;
            }
        }

        @media (min-width: 1024px) {
            .hero-title {
                font-size: 3.75rem;
            }
        }

        .hero-title .gradient-text {
            background: linear-gradient(90deg, var(--accent-gold), var(--accent-rose), var(--accent-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: var(--text-muted);
            font-size: 0.875rem;
            max-width: 42rem;
            margin: 0 auto;
            line-height: 1.8;
            margin-top: 1.5rem;
        }

        @media (min-width: 640px) {
            .hero-desc {
                font-size: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .hero-desc {
                margin: 0;
                margin-top: 1.5rem;
            }
        }

        .hero-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding-top: 0.5rem;
            margin-top: 1.5rem;
        }

        @media (min-width: 640px) {
            .hero-buttons {
                flex-direction: row;
            }
        }

        @media (min-width: 1024px) {
            .hero-buttons {
                justify-content: flex-start;
            }
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            background: var(--accent-gold);
            color: #3b2969;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 12px 24px -6px rgba(251, 191, 36, 0.50);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: 1px solid rgba(251, 191, 36, 0.60);
        }

        @media (min-width: 640px) {
            .btn-primary {
                width: auto;
            }
        }

        .btn-primary:hover {
            background: #fcd34d;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -8px rgba(251, 191, 36, 0.65);
        }

        .btn-secondary {
            width: 100%;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.10);
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid var(--border-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }

        @media (min-width: 640px) {
            .btn-secondary {
                width: auto;
            }
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.20);
            border-color: var(--accent-sky);
            transform: translateY(-2px);
        }

        .btn-secondary i {
            color: var(--accent-sky);
            font-size: 1rem;
        }

        /* Hero Visual */
        .hero-visual {
            display: flex;
            justify-content: center;
        }

        .hero-visual-wrapper {
            position: relative;
            width: 100%;
            max-width: 28rem;
        }

        .hero-visual-glow {
            position: absolute;
            inset: -0.25rem;
            border-radius: 1.5rem;
            background: linear-gradient(90deg, var(--accent-rose), var(--accent-gold));
            opacity: 0.35;
            filter: blur(28px);
        }

        .hero-card {
            position: relative;
            padding: 1.5rem;
            border-radius: 1.5rem;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-lg);
            background: rgba(42, 22, 70, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hero-card-image {
            position: relative;
            height: 16rem;
            border-radius: 1rem;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.30);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .hero-card:hover .hero-card-image img {
            transform: scale(1.05);
        }

        .hero-card-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: var(--accent-rose);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.625rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(251, 113, 133, 0.45);
        }

        .hero-card-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
        }

        .hero-card-info h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .hero-card-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .hero-card-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--accent-gold);
        }

        /* Value Badges */
        .value-badges {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-glass);
        }

        @media (min-width: 768px) {
            .value-badges {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .value-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-glass);
            backdrop-filter: blur(8px);
            transition: all 0.2s;
        }

        .value-badge:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: var(--accent-gold);
            transform: translateY(-2px);
        }

        .value-badge-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .value-badge-icon.emerald {
            background: rgba(52, 211, 153, 0.18);
            color: var(--accent-emerald);
        }

        .value-badge-icon.blue {
            background: rgba(167, 139, 250, 0.18);
            color: var(--accent-violet);
        }

        .value-badge-icon.amber {
            background: rgba(251, 191, 36, 0.18);
            color: var(--accent-gold);
        }

        .value-badge-icon.sky {
            background: rgba(56, 189, 248, 0.18);
            color: var(--accent-sky);
        }

        .value-badge-text h4 {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .value-badge-text p {
            font-size: 0.6875rem;
            color: var(--text-muted);
        }

        /* ===== CATEGORY BAR ===== */
        .category-bar {
            padding: 1.5rem 0;
            background: rgba(42, 22, 70, 0.70);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: sticky;
            top: 5rem;
            z-index: 30;
            border-bottom: 1px solid var(--border-glass);
            box-shadow: var(--shadow-sm);
        }

        .category-bar-inner {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        @media (min-width: 1024px) {
            .category-bar-inner {
                flex-direction: row;
            }
        }

        .category-tabs {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            overflow-x: auto;
            width: 100%;
            padding-bottom: 0.5rem;
        }

        @media (min-width: 1024px) {
            .category-tabs {
                width: auto;
                padding-bottom: 0;
            }
        }

        .category-tabs::-webkit-scrollbar {
            height: 4px;
        }

        .category-tabs::-webkit-scrollbar-track {
            background: transparent;
        }

        .category-tabs::-webkit-scrollbar-thumb {
            background: var(--border-strong);
            border-radius: 4px;
        }

        .cat-tab {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-body);
            white-space: nowrap;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-glass);
        }

        .cat-tab:hover {
            background: rgba(255, 255, 255, 0.16);
            color: var(--accent-gold);
            border-color: rgba(251, 191, 36, 0.40);
        }

        .cat-tab.active {
            background: var(--accent-gold);
            color: #3b2969;
            font-weight: 700;
            border-color: var(--accent-gold);
            box-shadow: 0 4px 14px rgba(251, 191, 36, 0.40);
        }

        .cat-tab i {
            margin-right: 0.375rem;
        }

        .cat-tab i.blue {
            color: var(--accent-violet);
        }

        .cat-tab i.indigo {
            color: #a78bfa;
        }

        .cat-tab i.teal {
            color: var(--accent-emerald);
        }

        .cat-tab i.amber {
            color: var(--accent-gold);
        }

        .cat-tab.active i {
            color: #3b2969 !important;
        }

        .sort-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .sort-control {
                width: auto;
                justify-content: flex-end;
            }
        }

        .product-count {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .product-count span:first-child {
            color: var(--accent-gold);
            font-weight: 700;
        }

        .sort-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sort-wrapper label {
            font-size: 0.75rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        @media (max-width: 639px) {
            .sort-wrapper label {
                display: none;
            }
        }

        .sort-wrapper select {
            background: rgba(0, 0, 0, 0.30);
            color: var(--text-main);
            border: 1px solid var(--border-glass);
            font-size: 0.75rem;
            border-radius: 0.75rem;
            padding: 0.5rem 0.75rem;
            outline: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sort-wrapper select option {
            background: #3b2969;
            color: #fff;
        }

        .sort-wrapper select:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.20);
        }

        /* ===== PRODUCTS SECTION ===== */
        .products-section {
            padding: 2.5rem 0;
            background: transparent;
        }

        /* ===== PRODUCT GRID ===== */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 32px 0;
        }

        @media (min-width: 640px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* ===== CARD CONTAINER ===== */
        .product-card {
            position: relative;
            display: flex;
            flex-direction: column;
            border-radius: 16px;
            overflow: hidden;
            background: rgba(42, 22, 70, 0.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-md);
            transition: transform .35s cubic-bezier(.22, .61, .36, 1),
                box-shadow .35s ease,
                border-color .35s ease;
            isolation: isolate;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(251, 191, 36, 0.55);
            box-shadow: 0 20px 40px -12px rgba(251, 191, 36, 0.35),
                0 10px 20px rgba(0, 0, 0, 0.40);
        }

        /* ===== IMAGE ===== */
        .product-card-image {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.30);
            cursor: pointer;
            z-index: 1;
        }

        .product-card-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 60%, rgba(0, 0, 0, 0.25) 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity .3s ease;
        }

        .product-card:hover .product-card-image::after {
            opacity: 1;
        }

        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s cubic-bezier(.22, .61, .36, 1);
        }

        .product-card:hover .product-card-image img {
            transform: scale(1.08);
        }

        .no-product-image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: var(--text-soft);
            font-size: 13px;
            letter-spacing: .5px;
        }

        /* ===== BADGE ===== */
        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 2;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #3b2969;
            background: var(--accent-gold);
            border-radius: 999px;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.50);
            animation: badge-pulse 2.5s ease-in-out infinite;
        }

        @keyframes badge-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* ===== BODY ===== */
        .product-card-body {
            padding: 14px 14px 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
            position: relative;
            z-index: 1;
        }

        .product-title {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color .2s ease;
        }

        .product-card:hover .product-title {
            color: var(--accent-gold);
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
            min-height: 18px;
        }

        .product-brand {
            font-weight: 600;
            color: var(--text-body);
        }

        .product-model::before {
            content: "•";
            margin-right: 6px;
            color: var(--text-soft);
        }

        /* ===== FOOTER ===== */
        .product-card-footer {
            padding: 10px 14px 14px;
            border-top: 1px solid var(--border-glass);
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .product-card-price {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }

        .product-card-price .current {
            font-size: 19px;
            font-weight: 900;
            color: var(--accent-gold);
            letter-spacing: -0.3px;
            text-shadow: 0 2px 8px rgba(251, 191, 36, 0.30);
        }

        /* ===== ACTIONS ===== */
        .product-card-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .btn-detail,
        .product-card-actions .telegram-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 9px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .btn-detail {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid var(--border-glass);
        }

        .btn-detail:hover {
            background: rgba(255, 255, 255, 0.20);
            color: var(--accent-gold);
            border-color: rgba(251, 191, 36, 0.40);
            transform: translateY(-2px);
        }

        .product-card-actions .telegram-cta {
            display: inline-flex;
            color: #0c1e2e;
            background: var(--accent-sky);
            box-shadow: 0 2px 10px rgba(56, 189, 248, .40);
            font-weight: 700;
        }

        .product-card-actions .telegram-cta i {
            font-size: 13px;
        }

        .product-card-actions .telegram-cta:hover {
            background: #7dd3fc;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(56, 189, 248, .55);
        }

        /* ===== MOBILE ===== */
        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin: 20px 0;
            }

            .product-card-body {
                padding: 10px 10px 6px;
            }

            .product-title {
                font-size: 13px;
                -webkit-line-clamp: 2;
            }

            .product-meta {
                font-size: 11px;
            }

            .product-card-footer {
                padding: 8px 10px 10px;
                gap: 8px;
            }

            .product-card-price .current {
                font-size: 15px;
            }

            .product-card-actions {
                gap: 6px;
            }

            .btn-detail,
            .product-card-actions .telegram-cta {
                padding: 7px 6px;
                font-size: 11px;
                border-radius: 8px;
            }

            .product-card-actions .telegram-cta span {
                display: none;
            }

            .product-card-actions .telegram-cta i {
                font-size: 16px;
            }

            .product-badge {
                font-size: 9px;
                padding: 3px 8px;
                top: 8px;
                left: 8px;
            }
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 5rem 0;
        }

        .empty-state-icon {
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            font-size: 1.875rem;
            border: 1px solid var(--border-glass);
        }

        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .empty-state p {
            font-size: 0.75rem;
            color: var(--text-muted);
            max-width: 24rem;
            margin: 0.5rem auto 0;
        }

        .empty-state button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: var(--accent-gold);
            color: #3b2969;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: background 0.2s;
            box-shadow: 0 6px 16px rgba(251, 191, 36, 0.40);
        }

        .empty-state button:hover {
            background: #fcd34d;
            transform: translateY(-1px);
        }

        /* ===== POLICY SECTION ===== */
        .policy-section {
            padding: 3rem 0;
            background: rgba(0, 0, 0, 0.20);
            border-top: 1px solid var(--border-glass);
        }

        .policy-header {
            text-align: center;
            max-width: 42rem;
            margin: 0 auto 2.5rem;
        }

        .policy-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
        }

        @media (min-width: 640px) {
            .policy-header h2 {
                font-size: 1.5rem;
            }
        }

        .policy-header p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        @media (min-width: 640px) {
            .policy-header p {
                font-size: 0.875rem;
            }
        }

        .policy-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .policy-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .policy-card {
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid var(--border-glass);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: all 0.2s;
        }

        .policy-card:hover {
            border-color: rgba(251, 191, 36, 0.45);
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.12);
        }

        .policy-card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .policy-card-icon.blue {
            background: rgba(167, 139, 250, 0.18);
            color: var(--accent-violet);
        }

        .policy-card-icon.emerald {
            background: rgba(52, 211, 153, 0.18);
            color: var(--accent-emerald);
        }

        .policy-card-icon.indigo {
            background: rgba(251, 191, 36, 0.18);
            color: var(--accent-gold);
        }

        .policy-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .policy-card p {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            overflow-y: auto;
            background: rgba(20, 10, 40, 0.75);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-container {
            position: relative;
            width: 100%;
            max-width: 48rem;
            background: #2a1f4a;
            border-radius: 1.5rem;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin: 2rem 0;
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s;
        }

        .modal-container.show {
            transform: scale(1);
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 10;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.10);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            border: 1px solid var(--border-glass);
        }

        .modal-close:hover {
            background: var(--accent-rose);
            color: #fff;
        }

        .modal-close i {
            font-size: 1.125rem;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        @media (min-width: 768px) {
            .modal-grid {
                grid-template-columns: 5fr 7fr;
                padding: 2rem;
            }
        }

        .modal-image-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .modal-image-box {
            width: 100%;
            height: 16rem;
            border-radius: 1rem;
            background: rgba(0, 0, 0, 0.30);
            border: 1px solid var(--border-glass);
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        @media (min-width: 640px) {
            .modal-image-box {
                height: 18rem;
            }
        }

        .modal-image-box img {
            max-height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .modal-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.25rem 0.625rem;
            border-radius: 0.375rem;
            background: var(--accent-gold);
            color: #3b2969;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.40);
        }

        .modal-details {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .modal-category {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--text-main);
            margin-top: 0.25rem;
        }

        @media (min-width: 640px) {
            .modal-title {
                font-size: 1.5rem;
            }
        }

        .modal-price-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .modal-price {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--accent-gold);
        }

        .modal-original-price {
            font-size: 0.875rem;
            color: var(--text-soft);
            text-decoration: line-through;
        }

        .modal-specs-box {
            background: rgba(0, 0, 0, 0.25);
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border-glass);
        }

        .modal-specs-box h4 {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-body);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-specs-box h4 i {
            color: var(--accent-gold);
        }

        .modal-specs-box p {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-top: 0.5rem;
        }

        .modal-specs-footer {
            padding-top: 0.5rem;
            border-top: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.6875rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .modal-specs-footer i {
            margin-right: 0.25rem;
        }

        .modal-specs-footer i.emerald {
            color: var(--accent-emerald);
        }

        .modal-specs-footer i.blue {
            color: var(--accent-violet);
        }

        .modal-specs-footer strong {
            color: var(--text-main);
        }

        .modal-specs-footer strong.emerald {
            color: var(--accent-emerald);
        }

        .modal-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .modal-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding-top: 0.5rem;
        }

        .modal-btn-telegram {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: linear-gradient(90deg, var(--accent-sky), #0284c7);
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 10px 20px -5px rgba(56, 189, 248, 0.45);
            transition: all 0.2s;
        }

        @media (min-width: 640px) {
            .modal-btn-telegram {
                font-size: 0.875rem;
            }
        }

        .modal-btn-telegram:hover {
            background: linear-gradient(90deg, #7dd3fc, var(--accent-sky));
            transform: translateY(-2px);
        }

        .modal-btn-telegram i {
            font-size: 1.125rem;
        }

        .modal-btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .modal-btn-secondary {
            padding: 0.625rem 0.75rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.10);
            color: var(--text-main);
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 1px solid var(--border-glass);
            transition: background 0.2s;
        }

        .modal-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.20);
            border-color: var(--accent-gold);
        }

        .modal-btn-secondary i.red {
            color: var(--accent-rose);
        }

        .modal-btn-secondary i.emerald {
            color: var(--accent-emerald);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: rgba(0, 0, 0, 0.35);
            border-top: 1px solid var(--border-glass);
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-top: auto;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        @media (min-width: 640px) {
            .footer-inner {
                padding: 3rem 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .footer-inner {
                padding: 3rem 2rem;
            }
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-brand-logo-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-rose));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b2969;
            font-weight: 700;
        }

        .footer-brand-logo span {
            font-size: 1.125rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: 0.05em;
        }

        .footer-brand p {
            line-height: 1.7;
            color: var(--text-muted);
        }

        .footer-col h4 {
            font-size: 0.875rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.75rem;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .footer-col ul li a {
            transition: color 0.2s;
            color: var(--text-muted);
        }

        .footer-col ul li a:hover {
            color: var(--accent-gold);
        }

        .footer-col p {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .footer-col p i {
            margin-right: 0.5rem;
        }

        .footer-col p i.blue {
            color: var(--accent-violet);
        }

        .footer-col p i.red {
            color: var(--accent-rose);
        }

        .footer-col p i.emerald {
            color: var(--accent-emerald);
        }

        .footer-col p i.sky {
            color: var(--accent-sky);
        }

        .footer-telegram {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: var(--accent-sky);
            transition: background 0.2s;
            margin-top: 0.25rem;
        }

        .footer-telegram:hover {
            background: rgba(56, 189, 248, 0.25);
            color: #7dd3fc;
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-glass);
            text-align: center;
            color: var(--text-soft);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 639px) {
            .hero-title br {
                display: none;
            }

            .announcement-inner {
                justify-content: center;
            }

            .announcement-right {
                display: none;
            }
        }
    </style>
</head>

<body class="custom-scrollbar">

    <!-- 1. Top Announcement Bar -->
    <div class="announcement-bar">
        <div class="announcement-inner">
            <div class="announcement-left">
                <span class="divider hide-mobile">|</span>
                <span class="hide-mobile"><i class="fa-solid fa-shield-halved text-blue"></i> <span
                        data-i18n="announcement_warranty">100% Genuine Products with Official Warranty</span></span>
            </div>
            <div class="announcement-right">
                <a href="tel:+85512345678"><i class="fa-solid fa-phone text-emerald"></i> +855 12 345 678</a>
                <span class="divider">|</span>
                <?php
                $telegramLink = $settingsByKey['telegram_link'] ?? '';
                ?>
                <a href="<?= e($telegramLink) ?>" target="_blank"><i class="fa-brands fa-telegram text-sky"></i> Contact
                    us on Telegram</a>
            </div>
        </div>
    </div>

    <!-- 2. Executive Navbar -->
    <header class="navbar glass-nav">
        <div class="navbar-inner">
            <div class="navbar-row">
                <!-- Logo -->
                <div class="logo" onclick="window.scrollTo({top:0, behavior:'smooth'})">
                    <div class="logo-icon">
                        <?php if (!empty($settingsByKey['shop_logo'])): ?>
                            <img src="<?= e($settingsByKey['shop_logo']) ?>" alt="Shop Logo" class="shop-logo">
                        <?php else: ?>
                            <i class="fa-solid fa-microchip"></i>
                        <?php endif; ?>
                    </div>

                    <div>
                        <span class="logo-text">
                            <?= e($settingsByKey['shop_name'] ?? 'TECHHUB') ?>
                            <span class="logo-badge">KH</span>
                        </span>
                        <p class="logo-sub">Enterprise Technology</p>
                    </div>
                </div>

                <!-- Live Search Bar -->
                <div class="search-bar">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" oninput="handleSearch()"
                            data-i18n-placeholder="search_placeholder"
                            placeholder="Search iPhone, MacBook, Accessories...">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="nav-actions">
                    <!-- Language Switcher -->
                    <div class="lang-switcher">
                        <button onclick="changeLanguage('km')" id="lang-km" class="lang-btn">
                            <span>🇰🇭</span> KH
                        </button>
                        <button onclick="changeLanguage('en')" id="lang-en" class="lang-btn active">
                            <span>🇬🇧</span> EN
                        </button>
                    </div>

                    <!-- Telegram Button CTA -->
                    <a href="<?= e($telegramLink) ?>" target="_blank" class="telegram-cta">
                        <i class="fa-brands fa-telegram"></i>
                        <span data-i18n="nav_telegram_cta">Chat on Telegram</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="mobile-search">
                <div class="search-wrapper">
                    <input type="text" id="searchInputMobile" oninput="handleSearchMobile()"
                        data-i18n-placeholder="search_placeholder_mobile" placeholder="Search products...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Hero Banner Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="container hero-content">
            <div class="hero-grid">
                <!-- Hero Content -->
                <div class="hero-text">
                    <div class="hero-badge">
                        <span class="dot"></span>
                        <span data-i18n="hero_badge">NEXT-GEN TECH 2026</span>
                    </div>
                    <h1 class="hero-title">
                        <span data-i18n="hero_title_1">PREMIUM ENTERPRISE</span> <br class="hidden-mobile">
                        <span class="gradient-text" data-i18n="hero_title_2">ELECTRONICS HUB</span>
                    </h1>
                    <p class="hero-desc" data-i18n="hero_desc">
                        Providing 100% genuine smartphones, laptops, and smart gadgets with official warranty and
                        dedicated client support.
                    </p>
                    <div class="hero-buttons">
                        <a href="#products-section" class="btn-primary">
                            <span data-i18n="hero_btn_explore">Explore All Products</span>
                            <i class="fa-solid fa-arrow-down" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="<?= e($telegramLink) ?>" target="_blank" class="btn-secondary">
                            <i class="fa-brands fa-telegram"></i>
                            <span data-i18n="hero_btn_consult">Consult via Telegram</span>
                        </a>
                    </div>
                </div>

                <!-- Hero Product Visual Display -->
                <div class="hero-visual">
                    <div class="hero-visual-wrapper">
                        <div class="hero-visual-glow"></div>
                        <div class="hero-card glass-card">
                            <div class="hero-card-image">
                                <img id="heroDisplayImage"
                                    src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800&q=80"
                                    alt="Flagship Tech">
                                <div class="hero-card-badge">FLAGSHIP</div>
                            </div>
                            <div class="hero-card-info">
                                <div>
                                    <h3>iPhone 16 Pro Max</h3>
                                    <p>256GB / Titanium Natural</p>
                                </div>
                                <span class="hero-card-price">$1,299</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Value Proposition Badges -->
            <div class="value-badges">
                <div class="value-badge">
                    <div class="value-badge-icon emerald">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="value-badge-text">
                        <h4 data-i18n="badge_1_title">100% Original</h4>
                        <p data-i18n="badge_1_desc">Genuine Products</p>
                    </div>
                </div>
                <div class="value-badge">
                    <div class="value-badge-icon blue">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <div class="value-badge-text">
                        <h4 data-i18n="badge_2_title">Official Warranty</h4>
                        <p data-i18n="badge_2_desc">6 to 24 Months</p>
                    </div>
                </div>
                <div class="value-badge">
                    <div class="value-badge-icon amber">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="value-badge-text">
                        <h4 data-i18n="badge_3_title">24h Fast Delivery</h4>
                        <p data-i18n="badge_3_desc">Phnom Penh & Provinces</p>
                    </div>
                </div>
                <div class="value-badge">
                    <div class="value-badge-icon sky">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="value-badge-text">
                        <h4 data-i18n="badge_4_title">Direct Support</h4>
                        <p data-i18n="badge_4_desc">Expert Guidance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Category & Sorting Control Bar -->
    <section id="products-section" class="category-bar">
        <div class="container">
            <div class="category-bar-inner">
                <!-- Category Tabs — Dynamic ពី Database -->
                <div class="category-tabs custom-scrollbar">
                    <!-- Tab "All" (ស្ថិតនៅដើមជានិច្ច) -->
                    <button onclick="setCategory('all')" id="cat-all" class="cat-tab active">
                        <i class="fa-solid fa-border-all"></i>
                        <span data-i18n="cat_all">All Products</span>
                    </button>

                    <!-- Loop Categories ពី Database -->
                    <?php foreach (($categories ?? []) as $cat): ?>
                        <button onclick="setCategory('<?= htmlspecialchars($cat['slug']) ?>')"
                            id="cat-<?= htmlspecialchars($cat['slug']) ?>" class="cat-tab">
                            <i class="fa-solid fa-tag"></i>
                            <span>
                                <?= htmlspecialchars($cat['name']) ?>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Sort Control & Count -->
                <div class="sort-control">
                    <span class="product-count"><span id="productCount">0</span> <span
                            data-i18n="items_found">Products</span></span>
                    <div class="sort-wrapper">
                        <label for="sortSelect" data-i18n="sort_by">Sort By:</label>
                        <select id="sortSelect" onchange="handleSort()">
                            <option value="default" data-i18n="sort_default">Default</option>
                            <option value="price-low" data-i18n="sort_low_high">Price: Low to High</option>
                            <option value="price-high" data-i18n="sort_high_low">Price: High to Low</option>
                            <option value="newest" data-i18n="sort_newest">Newest Arrivals</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Rich Product Grid Container -->
    <section class="products-section">
        <div class="container">
            <section class="product-grid">

                <?php foreach (($products ?? []) as $product): ?>
                    <div class="product-card glass-card"
                        data-category="<?= htmlspecialchars($product['category_slug'] ?? 'all') ?>">

                        <div class="product-card-image" onclick="openModal(<?= (int) $product['id'] ?>)">
                            <?php if (!empty($product['image_path'])): ?>
                                <img src="<?= BASE_URL . '/' . htmlspecialchars($product['image_path'] ?? '') ?>"
                                    alt="<?= htmlspecialchars($product['name'] ?? 'Product') ?>">
                            <?php else: ?>
                                <div class="no-product-image">No image available</div>
                            <?php endif; ?>

                            <span class="product-badge">New</span>
                        </div>

                        <div class="product-card-body">
                            <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>

                            <p class="product-meta">
                                <span class="product-brand"><?= htmlspecialchars($product['brand'] ?? '') ?></span>
                                <span class="product-model"><?= htmlspecialchars($product['model'] ?? '') ?></span>
                            </p>
                        </div>

                        <div class="product-card-footer">
                            <div class="product-card-price">
                                <span class="current">$<?= number_format((float) $product['price'], 2) ?></span>
                            </div>

                            <div class="product-card-actions">
                                <a href="<?= BASE_URL ?>/website/product/<?= (int) $product['id'] ?>" class="btn-detail">
                                    View Details
                                </a>
                                <a href="<?= e($telegramLink) ?>" target="_blank" class="telegram-cta">
                                    <i class="fa-brands fa-telegram"></i>
                                    <span data-i18n="nav_telegram_cta">Chat on Telegram</span>
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </section>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state hidden">
                <div class="empty-state-icon"><i class="fa-solid fa-box-open"></i></div>
                <h3 data-i18n="empty_title">No products found</h3>
                <p data-i18n="empty_desc">Please try searching with another keyword or reset category filter.</p>
                <button onclick="resetFilters()">
                    <span data-i18n="btn_reset">Reset All Filters</span>
                </button>
            </div>
        </div>
    </section>

    <!-- 6. Guarantee & Policy Section -->
    <section class="policy-section">
        <div class="container">
            <div class="policy-header">
                <h2 data-i18n="policy_main_title">Enterprise Trust & Guarantees</h2>
                <p data-i18n="policy_main_desc">We are committed to delivering the most reliable and secure tech
                    shopping experience.</p>
            </div>

            <div class="policy-grid">
                <div class="policy-card glass-card">
                    <div class="policy-card-icon blue">
                        <i class="fa-solid fa-shield-virus"></i>
                    </div>
                    <h3 data-i18n="policy_1_title">Official Warranty Policy</h3>
                    <p data-i18n="policy_1_desc">All electronics come with 6 to 24 months official manufacturer
                        warranty with 1-to-1 replacement for defects.</p>
                </div>

                <div class="policy-card glass-card">
                    <div class="policy-card-icon emerald">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <h3 data-i18n="policy_2_title">7-Day Replacement</h3>
                    <p data-i18n="policy_2_desc">Flexible exchange policy within the first 7 days for unopened and
                        unused items.</p>
                </div>

                <div class="policy-card glass-card">
                    <div class="policy-card-icon indigo">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 data-i18n="policy_3_title">Phnom Penh Showroom</h3>
                    <p data-i18n="policy_3_desc">Visit our physical store for live demo and testing. Open daily from
                        8:00 AM to 8:00 PM.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Dynamic Product Detail Modal -->
    <div id="productModal" class="modal-overlay hidden">
        <div class="modal-container" id="modalContainer">
            <!-- Close Button -->
            <button onclick="closeModal()" class="modal-close">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-grid">
                <!-- Modal Left: Product Image -->
                <div class="modal-image-wrapper">
                    <div class="modal-image-box">
                        <img id="modalImage" src="" alt="Product Detail">
                        <span id="modalBadge" class="modal-badge">Stock</span>
                    </div>
                </div>

                <!-- Modal Right -->
                <div class="modal-details">
                    <div>
                        <span id="modalCategory" class="modal-category">Category</span>
                        <h2 id="modalTitle" class="modal-title">Product Title</h2>
                        <div class="modal-price-row">
                            <span id="modalPrice" class="modal-price">$0</span>
                            <span id="modalOriginalPrice" class="modal-original-price">$0</span>
                        </div>
                    </div>

                    <!-- Specs List Box -->
                    <div class="modal-specs-box">
                        <h4>
                            <i class="fa-solid fa-sliders"></i> <span data-i18n="modal_specs_label">Specifications
                                (Specs):</span>
                        </h4>
                        <p id="modalSpecs">Specification details...</p>

                        <div class="modal-specs-footer">
                            <span><i class="fa-solid fa-shield emerald"></i> <span
                                    data-i18n="modal_warranty">Warranty:</span> <strong id="modalWarranty">1
                                    Year</strong></span>
                            <span><i class="fa-solid fa-circle-check blue"></i> <span
                                    data-i18n="modal_status">Status:</span> <strong id="modalStatus" class="emerald">In
                                    Stock</strong></span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p id="modalDesc" class="modal-desc">Product description goes here...</p>

                    <!-- Order Call to Actions -->
                    <div class="modal-actions">
                        <a id="modalTelegramLink" href="#" target="_blank" class="modal-btn-telegram">
                            <i class="fa-brands fa-telegram"></i>
                            <span data-i18n="btn_order_telegram">Order Now via Telegram</span>
                        </a>

                        <div class="modal-btn-group">
                            <a id="modalGmailLink" href="#" target="_blank" class="modal-btn-secondary">
                                <i class="fa-solid fa-envelope red"></i>
                                <span data-i18n="btn_inquire_gmail">Send Gmail</span>
                            </a>
                            <a href="tel:+85512345678" class="modal-btn-secondary">
                                <i class="fa-solid fa-phone emerald"></i>
                                <span data-i18n="btn_call">Call Direct</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 8. Professional Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <!-- Col 1 -->
                <div class="footer-brand">
                    <div class="footer-brand-logo">
                        <div class="footer-brand-logo-icon">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span>TECHHUB KH</span>
                    </div>
                    <p data-i18n="footer_brand_desc">Cambodia's premier technology and electronics showcase center.</p>
                </div>

                <!-- Col 2 -->
                <div class="footer-col">
                    <h4 data-i18n="footer_links_title">Quick Links</h4>
                    <ul>
                        <li><a href="#products-section" onclick="setCategory('smartphones')"
                                data-i18n="cat_phones">Smartphones</a></li>
                        <li><a href="#products-section" onclick="setCategory('laptops')" data-i18n="cat_laptops">Laptops
                                & PCs</a></li>
                        <li><a href="#products-section" onclick="setCategory('tablets')"
                                data-i18n="cat_tablets">Tablets</a></li>
                        <li><a href="#products-section" onclick="setCategory('accessories')"
                                data-i18n="cat_accessories">Accessories</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div class="footer-col">
                    <h4 data-i18n="footer_hours_title">Hours & Location</h4>
                    <p><i class="fa-regular fa-clock blue"></i> <span data-i18n="footer_hours">Mon - Sun: 8:00 AM -
                            8:00 PM</span></p>
                    <p><i class="fa-solid fa-location-dot red"></i> <span data-i18n="footer_location">St. 271, Phnom
                            Penh, Cambodia</span></p>
                </div>

                <!-- Col 4 -->
                <div class="footer-col">
                    <h4 data-i18n="footer_contact_title">Direct Contact</h4>
                    <p><i class="fa-solid fa-phone emerald"></i> +855 12 345 678 / 97 888 999</p>
                    <p><i class="fa-solid fa-envelope sky"></i> sales@techhub.com.kh</p>
                    <a href="<?= e($telegramLink) ?>" target="_blank" class="footer-telegram">
                        <i class="fa-brands fa-telegram"></i> Telegram Channel
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p data-i18n="footer_copy">&copy; 2026 TECHHUB CAMBODIA. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Application Engine -->
    <script>
        // ===== Configuration =====
        const TELEGRAM_USERNAME = "Gonna_beYour";
        const GMAIL_ADDRESS = "sales@techhub.com.kh";

        // ===== State =====
        let currentCategory = 'all';
        let searchQuery = '';
        let currentSort = 'default';
        let currentProduct = null;
        let currentLang = 'en';

        // ===== Multilingual Dictionary =====
        const dictionary = {
            km: {
                announcement_warranty: "ទំនិញសុទ្ធ ១០០% មានការធានាផ្លូវការ",
                nav_telegram_cta: "ឆាតសួរព័ត៌មាន",
                search_placeholder: "ស្វែងរក iPhone, MacBook, Accessories...",
                search_placeholder_mobile: "ស្វែងរកផលិតផល...",
                hero_badge: "បច្ចេកវិទ្យាជំនាន់ថ្មី ២០២៦",
                hero_title_1: "មជ្ឈមណ្ឌលគ្រឿង",
                hero_title_2: "អេឡិចត្រូនិចទំនើប",
                hero_desc: "ផ្តល់ជូននូវទូរស័ព្ទដៃ កុំព្យូទ័រ និងឧបករណ៍ឆ្លាតវៃដើម ១០០% មានការធានាផ្លូវការ និងសេវាកម្មថែទាំអតិថិជនយ៉ាងយកចិត្តទុកដាក់បំផុត។",
                hero_btn_explore: "មើលផលិតផលទាំងអស់",
                hero_btn_consult: "ពិគ្រោះតាម Telegram",
                badge_1_title: "ទំនិញសុទ្ធ ១០០%",
                badge_1_desc: "Genuine Products",
                badge_2_title: "មានការធានាត្រឹមត្រូវ",
                badge_2_desc: "Official Warranty",
                badge_3_title: "ដឹកជញ្ជូនរហ័ស ២៤h",
                badge_3_desc: "Express Delivery",
                badge_4_title: "គាំទ្របច្ចេកទេស",
                badge_4_desc: "Direct Tech Support",
                cat_all: "ទាំងអស់",
                cat_phones: "ទូរស័ព្ទដៃ",
                cat_laptops: "កុំព្យូទ័រ",
                cat_tablets: "ថេប្លេត",
                cat_accessories: "គ្រឿងបន្លាស់",
                items_found: "ផលិតផល",
                sort_by: "តម្រៀបតាម:",
                sort_default: "ទូទៅ (Default)",
                sort_low_high: "តម្លៃ៖ ទាប ទៅ ខ្ពស់",
                sort_high_low: "តម្លៃ៖ ខ្ពស់ ទៅ ទាប",
                sort_newest: "ផលិតផលថ្មីៗ",
                empty_title: "មិនមានផលិតផលតាមតម្រូវការទេ",
                empty_desc: "សូមព្យាយាមស្វែងរកជាមួយពាក្យគន្លឹះផ្សេងទៀត ឬជ្រើសរើសប្រភេទផលិតផលឡើងវិញ។",
                btn_reset: "បង្ហាញទាំងអស់ឡើងវិញ",
                policy_main_title: "សេវាកម្ម និងការធានាទំនុកចិត្ត",
                policy_main_desc: "យើងខ្ញុំប្តេជ្ញាផ្តល់ជូននូវបទពិសោធន៍ទិញទំនិញដែលមានសុវត្ថិភាព និងភាពជឿជាក់ខ្ពស់បំផុត។",
                policy_1_title: "គោលការណ៍ធានាផ្លូវការ",
                policy_1_desc: "រាល់ផលិតផលទាំងអស់ទទួលបានការធានារយៈពេលពី ៦ ខែ ដល់ ២ ឆ្នាំ ចេញពីក្រុមហ៊ុនផ្ទាល់ ជាមួយការប្តូរថ្មីភ្លាមៗប្រសិនមានបញ្ហាបច្ចេកទេស។",
                policy_2_title: "ការផ្លាស់ប្តូរទំនិញក្នុង ៧ថ្ងៃ",
                policy_2_desc: "អតិថិជនអាចស្នើសុំផ្លាស់ប្តូរម៉ូឌែល ឬពណ៌បានក្នុងរយៈពេល ៧ ថ្ងៃដំបូង ប្រសិនបើផលិតផលមិនទាន់ត្រូវបានបើកប្រអប់ ឬប្រើប្រាស់។",
                policy_3_title: "ហាងផ្ទាល់នៅភ្នំពេញ",
                policy_3_desc: "លោកអ្នកអាចអញ្ជើញមកតេស្ត និងពិនិត្យទំនិញផ្ទាល់នៅទីតាំងហាងយើងខ្ញុំបាន រៀងរាល់ថ្ងៃចាប់ពីម៉ោង ៨:០០ ព្រឹក ដល់ ៨:០០ យប់។",
                modal_specs_label: "ព័ត៌មានបច្ចេកទេស (Specs):",
                modal_warranty: "ការធានា:",
                modal_status: "ស្ថានភាព:",
                modal_in_stock: "មានស្តុក",
                btn_order_telegram: "កម្ម៉ង់ភ្លាមៗតាម Telegram",
                btn_inquire_gmail: "ផ្ញើ Gmail",
                btn_call: "ទូរស័ព្ទផ្ទាល់",
                btn_details: "មើលលម្អិត",
                btn_buy_tg: "ទិញតាម Telegram",
                footer_brand_desc: "មជ្ឈមណ្ឌលចែកចាយ និងបង្ហាញផលិតផលបច្ចេកវិទ្យាគ្រឿងអេឡិចត្រូនិចឈានមុខគេនៅកម្ពុជា។",
                footer_links_title: "តំណភ្ជាប់រហ័ស",
                footer_hours_title: "ម៉ោងធ្វើការ & ទីតាំង",
                footer_hours: "ចន្ទ - អាទិត្យ: 8:00 AM - 8:00 PM",
                footer_location: "ផ្លូវ ២៧១ រាជធានីភ្នំពេញ, កម្ពុជា",
                footer_contact_title: "ទំនាក់ទំនងផ្ទាល់",
                footer_copy: "&copy; 2026 TECHHUB CAMBODIA. រក្សាសិទ្ធិគ្រប់យ៉ាង (All Rights Reserved)."
            },
            en: {
                announcement_warranty: "100% Genuine Products with Official Warranty",
                nav_telegram_cta: "Chat on Telegram",
                search_placeholder: "Search iPhone, MacBook, Accessories...",
                search_placeholder_mobile: "Search products...",
                hero_badge: "NEXT-GEN TECH 2026",
                hero_title_1: "PREMIUM ENTERPRISE",
                hero_title_2: "ELECTRONICS HUB",
                hero_desc: "Providing 100% genuine smartphones, laptops, and smart gadgets with official warranty and dedicated client support.",
                hero_btn_explore: "Explore All Products",
                hero_btn_consult: "Consult via Telegram",
                badge_1_title: "100% Original",
                badge_1_desc: "Genuine Products",
                badge_2_title: "Official Warranty",
                badge_2_desc: "6 to 24 Months",
                badge_3_title: "24h Fast Delivery",
                badge_3_desc: "Phnom Penh & Provinces",
                badge_4_title: "Direct Support",
                badge_4_desc: "Expert Guidance",
                cat_all: "All Products",
                cat_phones: "Smartphones",
                cat_laptops: "Laptops & PCs",
                cat_tablets: "Tablets",
                cat_accessories: "Accessories",
                items_found: "Products",
                sort_by: "Sort By:",
                sort_default: "Default",
                sort_low_high: "Price: Low to High",
                sort_high_low: "Price: High to Low",
                sort_newest: "Newest Arrivals",
                empty_title: "No products found",
                empty_desc: "Please try searching with another keyword or reset category filter.",
                btn_reset: "Reset All Filters",
                policy_main_title: "Enterprise Trust & Guarantees",
                policy_main_desc: "We are committed to delivering the most reliable and secure tech shopping experience.",
                policy_1_title: "Official Warranty Policy",
                policy_1_desc: "All electronics come with 6 to 24 months official manufacturer warranty with 1-to-1 replacement for defects.",
                policy_2_title: "7-Day Replacement",
                policy_2_desc: "Flexible exchange policy within the first 7 days for unopened and unused items.",
                policy_3_title: "Phnom Penh Showroom",
                policy_3_desc: "Visit our physical store for live demo and testing. Open daily from 8:00 AM to 8:00 PM.",
                modal_specs_label: "Specifications (Specs):",
                modal_warranty: "Warranty:",
                modal_status: "Status:",
                modal_in_stock: "In Stock",
                btn_order_telegram: "Order Now via Telegram",
                btn_inquire_gmail: "Send Gmail",
                btn_call: "Call Direct",
                btn_details: "View Details",
                btn_buy_tg: "Buy via Telegram",
                footer_brand_desc: "Cambodia's premier technology and electronics showcase center.",
                footer_links_title: "Quick Links",
                footer_hours_title: "Hours & Location",
                footer_hours: "Mon - Sun: 8:00 AM - 8:00 PM",
                footer_location: "St. 271, Phnom Penh, Cambodia",
                footer_contact_title: "Direct Contact",
                footer_copy: "&copy; 2026 TECHHUB CAMBODIA. All Rights Reserved."
            }
        };

        // ===== Get Product Cards rendered by PHP =====
        function getProductCards() {
            return Array.from(document.querySelectorAll('.product-card'));
        }

        // ===== Filter & Sort =====
        function renderProducts() {
            const cards = getProductCards();
            const emptyState = document.getElementById('emptyState');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = (card.querySelector('.product-title')?.textContent || '').toLowerCase();
                const brand = (card.querySelector('.product-brand')?.textContent || '').toLowerCase();
                const model = (card.querySelector('.product-model')?.textContent || '').toLowerCase();
                const cardCategory = card.dataset.category || 'all';

                const query = searchQuery.toLowerCase().trim();
                const matchesSearch = !query ||
                    title.includes(query) ||
                    brand.includes(query) ||
                    model.includes(query);

                const matchesCategory = currentCategory === 'all' || cardCategory === currentCategory;

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Sort (re-order DOM)
            const grid = document.querySelector('.product-grid');
            if (grid && currentSort !== 'default') {
                const visibleCards = cards.filter(c => c.style.display !== 'none');
                visibleCards.sort((a, b) => {
                    const getPrice = el => parseFloat(
                        (el.querySelector('.product-card-price .current')?.textContent || '0')
                            .replace(/[^0-9.]/g, '')
                    ) || 0;
                    if (currentSort === 'price-low') return getPrice(a) - getPrice(b);
                    if (currentSort === 'price-high') return getPrice(b) - getPrice(a);
                    return 0;
                });
                visibleCards.forEach(c => grid.appendChild(c));
            }

            const countEl = document.getElementById('productCount');
            if (countEl) countEl.textContent = visibleCount;

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }
        }

        // ===== Category =====
        function setCategory(cat) {
            currentCategory = cat;
            document.querySelectorAll('.cat-tab').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById(`cat-${cat}`);   // cat-smartphones, cat-laptops...
            if (activeBtn) activeBtn.classList.add('active');
            renderProducts();
        }

        // ===== Search =====
        function handleSearch() {
            searchQuery = document.getElementById('searchInput').value;
            renderProducts();
        }
        function handleSearchMobile() {
            searchQuery = document.getElementById('searchInputMobile').value;
            renderProducts();
        }

        // ===== Sort =====
        function handleSort() {
            currentSort = document.getElementById('sortSelect').value;
            renderProducts();
        }

        // ===== Reset =====
        function resetFilters() {
            searchQuery = '';
            document.getElementById('searchInput').value = '';
            document.getElementById('searchInputMobile').value = '';
            document.getElementById('sortSelect').value = 'default';
            currentSort = 'default';
            setCategory('all');
        }

        // ===== Language =====
        function changeLanguage(lang) {
            currentLang = lang;
            document.documentElement.lang = lang;
            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById(`lang-${lang}`)?.classList.add('active');

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dictionary[lang]?.[key] !== undefined) {
                    el.innerHTML = dictionary[lang][key];
                }
            });
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (dictionary[lang]?.[key]) el.placeholder = dictionary[lang][key];
            });
        }

        // ===== Init =====
        window.addEventListener('DOMContentLoaded', () => {
            // Set default language to English
            changeLanguage('en');

            const countEl = document.getElementById('productCount');
            if (countEl) countEl.textContent = getProductCards().length;
        });
    </script>
</body>

</html>
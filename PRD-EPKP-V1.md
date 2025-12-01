# Product Requirements Document (PRD): E-PKP (Employee Performance Assessment System)

| Property | Details |
| :--- | :--- |
| **Project Name** | E-PKP (Elektronik Penilaian Capaian Kinerja Pegawai) |
| **Version** | 1.0 (Final Draft) |
| **Status** | Ready for Development |
| **Product Manager** | Faiz Intifada |
| **Tech Stack** | CodeIgniter 3 (PHP), MySQL, Bootstrap (using provided Assets) |

## 1. Executive Summary (One Pager)

### 1.1 Problem Statement
Currently, the monthly performance assessment (PKP) is managed via decentralized Excel files. This causes issues such as:
* **Formula Errors:** Risk of broken references (`#REF!`) when rows are deleted.
* **Printing Inflexibility:** Difficult to hide inactive tasks for printing without deleting data rows.
* **Administrative Burden:** Redundant data entry for recurring signatory details and lack of historical data centralization.

### 1.2 Objectives
To build a web-based application that replaces the Excel workflow with a dynamic, database-driven system. Key goals:
* **Centralized Data:** Secure storage of employee performance history.
* **Dynamic Reporting:** Allow "Hide Inactive" toggle for printing.
* **Flexibility:** Users can input different Appraisers (*Pejabat Penilai*) for each month to accommodate organizational changes.

### 1.3 Target Audience
1.  **Admin:** Manages master data (Units, Positions) and imports employee accounts.
2.  **Pegawai (Employee):** Inputs annual targets, monthly realizations, appraiser details, and generates PDF reports.

---

## 2. Functional Requirements

### 2.1 User Management & Authentication
* **Login System:** Simple username (NIP) and password authentication.
* **Role-Based Access Control (RBAC):**
    * `Admin`: Full access to settings and master data.
    * `Pegawai`: Access to own PKP data input and printing.
* **Import Feature (Admin):**
    * Ability to bulk import employee data (NIP, Name, Initial Rank/Position) via Excel/CSV template to create accounts.

### 2.2 Master Data Configuration (Admin)
To ensure the app is usable for future years, Admin must be able to manage:
* **Fiscal Year:** Setup active year (e.g., 2025, 2026).
* **Master Data:** CRUD (Create, Read, Update, Delete) for:
    * Unit Kerja (Work Units).
    * Pangkat/Golongan (Ranks).
    * Jabatan (Positions).

### 2.3 Annual Planning (Rencana Kinerja Tahunan)
* **Target Input:** Employees input their list of activities (Kegiatan Tugas Jabatan) at the start of the year.
* **Fields:**
    * Activity Name.
    * Target Quantity (Output).
    * Target Quality (Mutu - usually 100%).
    * Unit (e.g., Dokumen, Kegiatan, Laporan).
    * Credit Score (Angka Kredit) - optional.

### 2.4 Monthly Realization (Realisasi Bulanan) - *Core Feature*
Employees open a specific month (e.g., January) and perform the following:

#### A. Input Realization
* System displays all "Annual Targets".
* Employee inputs:
    * **Realization Output** (Qty).
    * **Realization Quality** (Mutu).
* **Auto-Calculation:**
    * `Score per Activity = (Realization / Target) * 100` (Standard logic).
    * `Final Monthly Score = Average of all Activity Scores`.
    * `Predikat` (Text Label):
        * > 90 : "Sangat Baik"
        * 76 - 90 : "Baik"
        * < 76 : "Cukup/Kurang" (Adjustable in code).

#### B. Dynamic Appraiser Input (Pejabat Penilai)
* Since signatories change, the user **MUST** input these details manually for **every month**:
    * **Pejabat Penilai Name.**
    * **NIP.**
    * **Jabatan (Position).**
    * **Atasan Pejabat Penilai** (Optional/If required by format).
* *UX Improvement:* The system should auto-fill these fields based on the previous month's data to save time, but allow editing.

### 2.5 Reporting & Printing
* **The "Hide" Feature:**
    * In the "Print Preview" or "Monthly View", add a Checkbox/Toggle next to each activity: **"Active this month?"**.
    * If unchecked, the row is excluded from the generated PDF/Print layout, but the data remains in the Annual Plan database.
* **PDF Generation:**
    * Format must strictly follow the official layout (header, columns, footer with signatures).
    * Date of signature must be customizable (e.g., "Gorontalo, 31 Januari 2025").

---

## 3. Technical Considerations

### 3.1 Tech Stack
* **Framework:** CodeIgniter 3 (PHP).
* **Database:** MySQL.
* **Frontend:** HTML5, CSS3, JavaScript (jQuery/Vanilla).
* **Styling:** Use the provided assets in the `assets/` folder (ensure responsiveness).

### 3.2 Database Schema (Proposed High-Level)
* `users` (id, nip, password, name, role, unit_id).
* `ref_years` (id, year, status).
* `pkp_targets` (id, user_id, year_id, activity_name, target_qty, target_quality, unit).
* `pkp_monthly` (id, target_id, month, real_qty, real_quality, is_active_print).
* `pkp_signatures` (id, user_id, month, year, appraiser_name, appraiser_nip, appraiser_position).

### 3.3 Security
* **Password Hashing:** Use standard bcrypt/argon2.
* **Input Validation:** Prevent SQL Injection and XSS (CI3 standard protection).

---

## 4. Features Out (Not in Scope for v1.0)
* **Digital Signatures:** The app only prints the name/NIP; signatures remain manual (wet ink).
* **Approval Workflow:** No "Submit -> Approve" button. It is a self-assessment recording tool.
* **Mobile App:** Web-based responsive view only.

---

## 5. Success Metrics
* **100% Data Accuracy:** No calculation errors compared to manual Excel check.
* **Printing Efficiency:** Users can generate a clean printout (hiding empty rows) in under 3 clicks.
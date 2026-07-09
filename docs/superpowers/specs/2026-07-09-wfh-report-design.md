# Design Specification: WFH Report Feature for E-PKP

## 1. Goal & Context
Adding a feature to the E-PKP (Employee Performance Assessment System) application to allow employees (`pegawai`) to log their daily Work From Home (WFH) activities and print a daily WFH report. The printed layout must exactly match the format of the sample Word document (`LAPORAN KERJA HARIAN ASN (WFH) [Jum'at 01-06-26].docx`).

## 2. Requirements & Scope
- **User Role**: Strictly for `pegawai`. No admin-specific views or workflows (approval/rejection) are required.
- **Workflow**:
  - Employee opens the **Laporan WFH** menu.
  - Sees a table of past WFH reports.
  - Can click **Tambah Laporan** to open a single-page form.
  - The form allows selecting a WFH date, dynamically adding/removing activity rows via jQuery, and uploading multiple screenshot images.
  - Saving creates/updates the database records and stores uploaded files.
  - The employee can edit or delete their WFH reports.
  - The employee can print the report via a print-friendly page using the browser's native print function (`window.print()`).

## 3. Database Schema

### Table: `wfh_reports`
Stores report headers.
```sql
CREATE TABLE `wfh_reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `wfh_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_date` (`user_id`, `wfh_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Table: `wfh_activities`
Stores individual activity rows.
```sql
CREATE TABLE `wfh_activities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `wfh_report_id` INT NOT NULL,
  `work_time` VARCHAR(100) NOT NULL,
  `activity_description` TEXT NOT NULL,
  `output_result` VARCHAR(255) NOT NULL,
  `note` VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (`wfh_report_id`) REFERENCES `wfh_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Table: `wfh_attachments`
Stores references to uploaded screenshot images.
```sql
CREATE TABLE `wfh_attachments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `wfh_report_id` INT NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`wfh_report_id`) REFERENCES `wfh_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 4. Components & Architecture (CodeIgniter 3)

### Controller
`application/controllers/pegawai/Wfh.php`
- `index()`: Display list of WFH reports for the logged-in user.
- `add()`: Show form to create a new WFH report.
- `edit($id)`: Show form to edit an existing WFH report.
- `save()`: Process creating/updating WFH reports. Handles form submission, file upload (under `assets/uploads/wfh/`), and database inserts/updates.
- `delete($id)`: Delete a WFH report (associated activities and attachments will cascade delete, files will be deleted from disk).
- `print_preview($id)`: Render a print-friendly page for the WFH report.

### Model
`application/models/Wfh_model.php`
- `get_all_by_user($user_id)`
- `get_by_id($id, $user_id)`
- `get_activities($wfh_report_id)`
- `get_attachments($wfh_report_id)`
- `insert_report($data)`
- `update_report($id, $data)`
- `delete_report($id)`
- `insert_activity($data)`
- `delete_activities_by_report($wfh_report_id)`
- `insert_attachment($data)`
- `delete_attachment($id)`

### Views
- `application/views/pegawai/wfh/index.php`: Report list with Add/Edit/Delete/Print actions.
- `application/views/pegawai/wfh/form.php`: Form to add/edit WFH reports, with date picker, dynamic table rows, and image multi-upload.
- `application/views/pegawai/wfh/print.php`: Print preview page utilizing `@media print` CSS for exact Word matching.

## 5. UI and Print Aesthetics
- **Forms**: Consistent with AdminLTE 3 / Bootstrap 4 styles used in other Pegawai pages.
- **Printed Layout**:
  - Center-aligned bold titles.
  - Borderless employee profile table.
  - Table with solid 1px black borders for activities list.
  - "Lampiran" section displaying screenshots in a single-column layout, page-break-friendly.

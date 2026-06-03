# Changelog

## 1.1.0 (2026-06-03)

Full API v2 surface parity.

### Added
- `Scanner\VeryQuickScan` — `POST /veryquickscan` (fast OCR-only scan).
- `AML\AMLV3Search` — `POST /amlv3` (AML v3 full-text / id lookup search).
- `Docupass\DocupassDetail` — `GET /docupass/{reference}` (fetch a single Docupass).
- Examples for the three new endpoints under `/example`.

### Notes
- Base URL is unchanged: US `https://api2.idanalyzer.com` (default), EU
  `https://api2-eu.idanalyzer.com` via `new Client($key, "eu")`.
- README corrected (removed copy-pasted "Python demos" / nodejs reference link).

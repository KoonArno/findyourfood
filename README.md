# FindYourFood 🍽️

เว็บแอป PHP สำหรับค้นหา/ดูเมนูอาหาร แบ่งตามประเภท (อาหาร/ของหวาน/เครื่องดื่ม) พร้อมระบบล็อกอิน การ์ดรายการ และ Modal แสดงรายละเอียด รองรับการค้นหาแบบบางส่วน (partial search)

> โฮสต์ตัวอย่าง: _ใส่ลิงก์ของคุณที่นี่_ เช่น `https://<your-domain>/findyourfood/`

---

## ✨ ฟีเจอร์หลัก

- แสดงเมนูอาหารแบบการ์ด แยกตามประเภท (อาหารจานเดียว/สุขภาพ/ของทานเล่น/เบเกอรี่/น้ำปั่น/น้ำชา/น้ำโซดา)
- ค้นหาด้วยคำบางส่วน (SQL `LIKE '%keyword%'`)
- Modal รายละเอียด: วัตถุดิบ วิธีทำ ผู้เขียน
- โค้ดแบบหน้าแม่แบบ (template) ไฟล์เดียว ใช้ซ้ำข้ามหมวด ลดโค้ดซ้ำ
- แยกค่าลับลง `.env` (ไม่ commit) เพื่อความปลอดภัย

---

## 🧱 สแต็กและไลบรารี

- **Backend:** PHP 7.4+ (PDO) + MySQL/MariaDB
- **Frontend:** Bootstrap 5, Bootstrap Icons
- **Hosting:** ByetHost/Any shared hosting ที่รองรับ PHP + MySQL
- **OS Note:** Linux/Unix hosts **ไวต่อตัวพิมพ์เล็ก-ใหญ่** (case‑sensitive) ทั้งชื่อไฟล์/พาธและชื่อตาราง

---

## 📁 โครงสร้างโปรเจกต์

```
findyourfood/
├─ db.php                   # อ่านค่า DB จาก .env → create PDO connection
├─ .env.example             # ตัวอย่างคีย์ลับ (คัดลอกไปเป็น .env)
├─ img/
│  ├─ no-image.png          # รูป fallback เมื่อหาภาพไม่เจอ
│  └─ ...                   # ภาพเมนู (เช่น 001.jpg, 046.png)
├─ menus/
│  ├─ common.php            # ฟังก์ชัน/คอนฟิก (fyf_guard, fyf_fetch_items, PATH)
│  ├─ list_by_type.php      # หน้าแม่แบบ list ตาม type_id
│  ├─ menu_header.php       # NAVBAR-ONLY (ไม่มี <html>/<body>)
│  ├─ main-styles.css       # (ถ้ามี) สไตล์หลัก
│  ├─ mheader-styles.css    # (ถ้ามี) สไตล์เมนู/เฮดเดอร์
│  ├─ food/
│  │  ├─ a_la_carte.php     # Wrapper → type_id=T01 (ปรับได้)
│  │  └─ healthy_food.php   # Wrapper → type_id=T02
│  ├─ dessert/
│  │  ├─ bakery.php         # Wrapper → type_id=T04/หรือที่คุณใช้
│  │  └─ Snacks.php         # Wrapper → type_id=T03/หรือที่คุณใช้
│  └─ drink/
│     ├─ Smoothie.php       # Wrapper → type_id=T05
│     ├─ tea.php            # Wrapper → type_id=T06
│     └─ Soda_water.php     # Wrapper → type_id=T07
├─ user_dashboard.php       # หน้าแดชบอร์ด + ฟอร์มค้นหา
├─ index.php                # (ถ้ามี) หน้าแรก
└─ README.md
```

> **Tip:** กำหนด `ROOT_PATH=/findyourfood/` และ `IMG_BASE_URL=ROOT_PATH.'img/'` เพื่อให้ path รูปเสถียรทุกหน้า

---

## 🗄️ โครงสร้างฐานข้อมูล (สรุป)

> โครงตามตัวอย่างที่ใช้ในโปรเจกต์ (ปรับได้ตามจริง)

### ตาราง `users`
| คอลัมน์ | ชนิดข้อมูล | หมายเหตุ |
|---|---|---|
| `user_id` | `varchar(10)` | PK |
| `username` | `varchar(50)` |  |
| `email` | `varchar(100)` |  |
| `password` | `varchar(255)` | เก็บรหัสผ่านแบบ hash (bcrypt) |
| `created_at` | `timestamp` |  |
| `role` | `varchar(20)` | ค่าเริ่มต้น `user` |

### ตาราง `type`
| คอลัมน์ | ชนิดข้อมูล | หมายเหตุ |
|---|---|---|
| `type_id` | `varchar(10)` | PK เช่น `T01`–`T07` |
| `type_name` | `varchar(255)` | ชื่อประเภท เช่น อาหารจานเดียว/อาหารสุขภาพ/… |

### ตาราง `food`
| คอลัมน์ | ชนิดข้อมูล | หมายเหตุ |
|---|---|---|
| `FoodId` | `varchar(10)` | PK เช่น `F01` |
| `user_id` | `varchar(10)` | FK → `users.user_id` |
| `Foodname` | `varchar(255)` | ชื่อเมนู |
| `Ingredient` | `text` | วัตถุดิบ |
| `details` | `text` | วิธีทำ |
| `type_id` | `varchar(10)` | FK → `type.type_id` |
| `image` | `varchar(255)` | ชื่อไฟล์รูปในโฟลเดอร์ `img/` |
| `created_at` | `timestamp` |  |
| `status` | `varchar(20)` | `pending`/`approved` |

ความสัมพันธ์: `users (1) ──< food >── (1) type`

---

/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - aljdwa-incubation-app
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`aljdwa-incubation-app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `aljdwa-incubation-app`;

/*Data for the table `application_status` */

insert  into `application_status`(`id`,`user_id`,`status`,`reason`,`status_by`,`created_at`,`updated_at`) values (1,'9d6d2e8d-821c-47af-b9df-20011213de18',11,NULL,NULL,'2024-11-06 19:49:51','2024-11-06 19:49:51');

/*Data for the table `appointments` */

/*Data for the table `appointments_schedule` */

/*Data for the table `cache` */

/*Data for the table `cache_locks` */

/*Data for the table `entrepreneur_agreement` */

/*Data for the table `entrepreneur_details` */

/*Data for the table `failed_jobs` */

/*Data for the table `job_batches` */

/*Data for the table `jobs` */

/*Data for the table `lookup_details` */

insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (1,1,'Admin','admin',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (2,1,'Mentor','mentor',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (3,1,'Entrepreneur','entrepreneur',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (4,1,'Investor','investor',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (5,2,'Active','active',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (6,2,'In-Active','in-active',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (7,3,'Pending','pending',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (8,3,'Booked','booked',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (9,3,'Cancelled','cancelled',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (10,3,'Completed','completed',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (11,4,'Pending','pending',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (12,4,'Returned','returned',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (13,4,'Resubmit','resubmit',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (14,4,'Rejected','rejected',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (15,4,'Approved','approved',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (16,5,'Scheduled','scheduled',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (17,5,'Re-Scheduled','re-scheduled',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (18,5,'Cancelled','cancelled',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (19,5,'Completed','completed',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (20,6,'Pending','pending',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (21,6,'Accepted','accepted',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (22,6,'Rejected','rejected',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (23,7,'Unpaid','unpaid',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (24,7,'Paid','paid',NULL,NULL);

/*Data for the table `lookups` */

insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (1,'Role','Role description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (2,'Active_status','Active status description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (3,'Appointment_status','Appointment status description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (4,'Application_status','Application status description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (5,'Meeting_status','Meeting status description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (6,'Agreement_status','Agreement status description',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (7,'Payment_status','Payment status description',NULL,NULL);

/*Data for the table `meetings` */

/*Data for the table `mentors_assignment` */

/*Data for the table `messages` */

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'0001_01_01_000001_create_cache_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (2,'0001_01_01_000002_create_jobs_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (3,'2024_10_18_000003_create_lookups_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (4,'2024_10_18_000004_create_lookup_details_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (5,'2024_10_18_000005_create_users_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (6,'2024_10_18_000006_create_application_status_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (7,'2024_10_18_000018_create_mentors_assignment_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (8,'2024_10_18_001117_create_meetings_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (9,'2024_10_18_195403_create_appointments_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (10,'2024_10_18_195404_create_entrepreneur_details_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (11,'2024_10_18_195406_create_appointments_schedule_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (12,'2024_10_18_195407_create_notifications_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (13,'2024_10_18_195410_create_entrepreneur_agreement_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (14,'2024_10_18_195419_create_payments_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (15,'2024_10_19_132507_create_personal_access_tokens_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (16,'2024_11_02_163405_create_messages_table',1);

/*Data for the table `notifications` */

/*Data for the table `payments` */

/*Data for the table `personal_access_tokens` */

insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (1,'App\\Models\\User','9d6d2e8d-821c-47af-b9df-20011213de18','app','9ef73c828cdaf4147c98535a311b95917780f21ff747f576ed83c9536285b0e1','[\"*\"]',NULL,NULL,'2024-11-06 19:50:24','2024-11-06 19:50:24');

/*Data for the table `users` */

insert  into `users`(`id`,`project_name`,`founder_name`,`email`,`country_code`,`phone_number`,`password`,`linkedin_profile`,`role`,`status`,`created_at`,`updated_at`) values ('9d6d2e8d-821c-47af-b9df-20011213de18',NULL,'Waris Raza','admin@gmail.com',92,'3001234567','$2y$12$m8AuF4rFdvE0e6fI8b6VS.9pWXo8stFGUiCnVU3JjkYO9O5ZcwvGm',NULL,1,5,'2024-11-06 19:49:41',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

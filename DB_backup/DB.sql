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

/*Data for the table `appoitments` */

/*Data for the table `cache` */

/*Data for the table `cache_locks` */

/*Data for the table `entreprenuer_agreement` */

/*Data for the table `entreprenuer_details` */

/*Data for the table `failed_jobs` */

/*Data for the table `job_batches` */

/*Data for the table `jobs` */

/*Data for the table `lookup_details` */

insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (1,1,'Admin','Admin',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (2,1,'Mentor','Mentor',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (3,1,'Entreprenuer','Entreprenuer',NULL,NULL);
insert  into `lookup_details`(`id`,`lookup_id`,`display_name`,`value`,`created_at`,`updated_at`) values (4,2,'Pending','Pending',NULL,NULL);

/*Data for the table `lookups` */

insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (1,'Role','',NULL,NULL);
insert  into `lookups`(`id`,`name`,`description`,`created_at`,`updated_at`) values (2,'Status','',NULL,NULL);

/*Data for the table `meetings` */

/*Data for the table `mentors_assignment` */

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'0001_01_01_000001_create_cache_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (2,'0001_01_01_000002_create_jobs_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (3,'2024_10_18_000003_create_lookups_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (4,'2024_10_18_000004_create_lookup_details_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (5,'2024_10_18_000005_create_users_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (6,'2024_10_18_195402_create_meetings_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (7,'2024_10_18_195404_create_entreprenuer_details_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (8,'2024_10_18_195405_create_appoitments_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (9,'2024_10_18_195406_create_mentors_assignment_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (10,'2024_10_18_195407_create_notifications_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (11,'2024_10_18_195409_create_payments_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (12,'2024_10_18_195410_create_entreprenuer_agreement_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (15,'2024_10_19_132507_create_personal_access_tokens_table',2);

/*Data for the table `notifications` */

/*Data for the table `payments` */

/*Data for the table `personal_access_tokens` */

insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (1,'App\\Models\\User','9d4a94b3-6d34-443c-a37c-8e0c816caca4','app','a5ef488b858a7d62100a23a6638f152ea675476b45fb27fd9ea34d5dc985c2c6','[\"*\"]',NULL,NULL,'2024-10-20 20:09:47','2024-10-20 20:09:47');
insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (2,'App\\Models\\User','9d4a94b3-6d34-443c-a37c-8e0c816caca4','app','07bdfaf57f1087ebab695effc3033217e07c887053e32d7af00cd927fffc40d9','[\"*\"]',NULL,NULL,'2024-10-20 20:10:16','2024-10-20 20:10:16');
insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (3,'App\\Models\\User','9d4a94b3-6d34-443c-a37c-8e0c816caca4','app','361e742e66870a4175564d353426d9a975d108af5b11d817cff6bd683fb387dd','[\"*\"]',NULL,NULL,'2024-10-20 21:33:10','2024-10-20 21:33:10');
insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (12,'App\\Models\\User','9d4cc2d0-c524-4051-89c9-c0990caf1f92','app','4514019b804f66720113e4c622d7e041d6f28ffed9206c9a8c50ec891f3c5bd5','[\"*\"]',NULL,NULL,'2024-10-21 17:25:07','2024-10-21 17:25:07');

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


   INFO  Running migrations.  

  2025_04_24_171037_create_messages_table ...............................................  
  ⇂ create table `messages` (`id` bigint unsigned not null auto_increment primary key, `sender_id` bigint unsigned not null, `receiver_id` bigint unsigned not null, `message` text not null, `is_read` tinyint(1) not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `messages` add constraint `messages_sender_id_foreign` foreign key (`sender_id`) references `users` (`id`) on delete cascade  
  ⇂ alter table `messages` add constraint `messages_receiver_id_foreign` foreign key (`receiver_id`) references `users` (`id`) on delete cascade  


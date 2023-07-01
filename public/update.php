<?php 

if(!pdo_fieldexists("fa_store_task", "error_count")) {
	pdo_query("ALTER TABLE ".tablename("fa_store_task")." ADD `error_count` tinyint(2)  DEFAULT '0' NOT NULL;");
}
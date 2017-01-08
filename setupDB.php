<?php
	ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php
	$host='localhost';
	$user='root';
	$pass='';
	$dbname='eshop';
	
	$db = mysqli_connect($host, $user, $pass);
	if(mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: ".mysqli_connect_error();
	}
	$query = "CREATE DATABASE IF NOT EXISTS	$dbname";
	
	mysqli_query($db, $query);
	mysqli_select_db($db, $dbname);

	$query = 'create table if not exists user(
		id integer auto_increment primary key,
		username varchar(50) unique not null,
		password blob(50) not null,
		dob date,
		email varchar(100) unique
	)';
	
	mysqli_query($db, $query);
	
	$query = 'create table if not exists items(
		itemid integer auto_increment primary key,
		name varchar(64) not null,
		price integer,
		qty integer,
		catid integer,
		picurl varchar(255)
	)';
	mysqli_query($db, $query);
	
	$query ='INSERT INTO items(name,price,qty,catid,picurl) VALUES
	("pencil",5,100,1,"products/1.jpg"),
	("blue book",6,100,1,"products/2.jpg"),
	("calculator",450,100,1,"products/3.jpg"),
	("eraser",3,100,1,"products/4.jpg"),
	("file",30,100,1,"products/5.jpg"),
	("glue stick",15,100,1,"products/6.jpg"),
	("pen",10,100,1,"products/7.jpg"),
	("notebook",20,100,1,"products/8.jpg"),
	("lab record",40,100,1,"products/9.jpg"),
	("pen drive",250,100,2,"products/10.jpg"),
	("GPIO wires",50,100,2,"products/11.jpg"),
	("HDMI cable",150,100,2,"products/12.jpg"),
	("RJ45 cable",100,100,2,"products/13.jpg"),
	("USB cable",50,100,2,"products/14.jpg"),
	("IC8086",250,100,2,"products/15.jpg"),
	("HEXA BLADE",6,100,3,"products/16.jpg"),
	("COMPASS",30,100,3,"products/17.jpg"),
	("MINI DRAFTER",150,100,3,"products/18.jpg"),
	("GEOMETRY BOX",50,100,3,"products/19.jpg"),
	("LAB UNIFORM",300,100,3,"products/20.jpg"),
	("MICROMETER",50,100,3,"products/21.jpg"),
	("STEAM TABLE",70,100,3,"products/22.jpg"),
	("FOOT SCALE",15,100,3,"products/23.jpg"),
	("ARDUINO",700,100,4,"products/24.jpg"),
	("BREAD BOARD",80,100,4,"products/25.jpg"),
	("DC MOTOR",50,100,4,"products/26.jpg"),
	("LED",15,100,4,"products/27.jpg"),
	("MULTIMETER",250,100,4,"products/28.jpg"),
	("PATCH CORD",25,100,4,"products/29.jpg"),
	("RESISTOR BOX",40,100,4,"products/30.jpg"),
	("SINGLE STRAND WIRE",20,100,4,"products/31.jpg"),
	("WIRE CUTTER",40,100,4,"products/32.jpg"),
	("CLIPS",6,100,5,"products/33.jpg"),
	("DRAWING SHEET",3,100,5,"products/34.jpg"),
	("FRENCH CURVES",30,100,5,"products/35.jpg"),
	("CONTAINER",40,100,5,"products/36.jpg"),
	("SAFETY HELMET",300,100,5,"products/37.jpg"),
	("LEVELING SCALE",25,100,5,"products/38.jpg"),
	("DRAWING SET",150,100,5,"products/39.jpg"),
	("STEEL TAPE",100,100,5,"products/40.jpg"),
	("T SQUARE",40,100,5,"products/41.jpg")';
	mysqli_query($db, $query);
	
	$query ='CREATE TABLE if not exists cart
			(
			itemid int NOT NULL,
			uid int NOT NULL,
			qty int,
			totprice double,
			PRIMARY KEY (itemid , uid),
			FOREIGN KEY (itemid) REFERENCES items(itemid) on delete cascade,
			FOREIGN KEY (uid) REFERENCES user(id) on delete cascade
			)	';
	mysqli_query($db, $query);
	
	$query ='CREATE TABLE if not exists orders
			(
			itemid int NOT NULL,
			uid int NOT NULL,
			qty int,
			totprice double,
			dt DATETIME NOT NULL,
			PRIMARY KEY (itemid , uid),
			FOREIGN KEY (itemid) REFERENCES items(itemid) on delete cascade,
			FOREIGN KEY (uid) REFERENCES user(id) on delete cascade
			
			)	';
	mysqli_query($db, $query);
	
	mysqli_close($db);
	echo "ES sucessfully set up on your server!";
?>

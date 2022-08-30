<?php
class Database
{
	private static $dbName = 'nodemcu_rfid_iot_projects';
	private static $dbHost = 'localhost';
	private static $dbUsername = 'root';
	private static $dbUserPassword = 'root';

	private static $cont  = null;

	public function __construct()
	{
		die('Init function is not allowed');
	}

	public static function connect()
	{
		// One connection through whole application
		if (null == self::$cont) {
			try {
				self::$cont =  new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		return self::$cont;
	}

	public static function disconnect()
	{
		self::$cont = null;
	}
	public static function Query($sql)
	{

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return $data;
	}
	// public static function GetCell($res){


	// 	return $data;
	// }
	public static function ValueExist($table, $id)
	{
		return Database::Query("SELECT count(*) as count FROM " . $table . " WHERE id = " . $id . ";")["count"] == 1;
	}
}

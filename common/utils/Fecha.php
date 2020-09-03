<?php
namespace app\common\utils;
use \DateTime;

class Fecha {
	
	const FORMATO_API_DATE = 'Ymd';
	const FORMATO_API_DATE_TIME = 'YmdHis';
	const FORMATO_API_DATE_TIME_SIN_SEGUNDOS = 'YmdHi';
	
	public static function stringToDateTime($stringDate, $format = "d/m/Y") {
		$d = DateTime::createFromFormat($format, $stringDate);
		
		if (strpos($format,'H')===false && strpos($format,'h')===false && strpos($format,'i')===false && strpos($format,'s')===false)
		    $d->setTime(0, 0, 0);
		if (! ($d && $d->format($format) == $stringDate)) {
			throw new \Exception("Ingrese una fecha válida: " . $format.' '.$stringDate);
		}
		return $d;
	}

	public static function dateTimeToString($dateTimeFecha, $format = "d/m/Y") {
		return $dateTimeFecha->format($format);
	}
	 

	/**
	 * Convierte la fecha de un formato a otro
	 * los formatos que pueden venir son Y-m-d (base de datos) o d/m/Y (vista)
	 * @param string $fecha
	 */
	public static function convertir($fecha){
		
		// 2016-11-10 12:32:44.149354
		//saco milisegundos
		if (!(strpos($fecha,'.')===false))
			$fecha = substr($fecha, 0,19);
		
		if (strpos($fecha,':')===false){
			$formatBD='Y-m-d';
			$formatView='d/m/Y';
		}	
		else{
			$formatBD='Y-m-d H:i:s';
			$formatView='d/m/Y H:i:s';
		}
		

		if (empty($fecha))
			null;
		elseif (strpos($fecha, '/')===false)
			$fecha= self::dateTimeToString(self::stringToDateTime($fecha,$formatBD),$formatView);
		else 
			$fecha= self::dateTimeToString(self::stringToDateTime($fecha,$formatView),$formatBD);

		return $fecha;
		
	}
	
	
	/**
	 * Devuelve la fecha y hora actual, con o sin formato.
	 * Si $conFormato=true devuelve date('Y-m-d H:i:s') con fines para visiualizar
	 * Si $conFormato=false devuelve date('Ymd His') 	con fines para guardar en la BD PostgreSQL 
	 * @param Boolean $conFormato
	 */
	public static function fechaHoraHoy($conFormato=true){
		if ($conFormato)
			return date('Y-m-d H:i:s');
		else
			return date('Ymd His');
	}
	
	public static function fechaHoy($conFormato=true){
		if ($conFormato)
			return date('Y-m-d');
		else
			return date('Ymd');
	}
	
	/***
	 * Toma la fecha y hora pasado por parametro y contruye el objeto DateTime 
	 * correspondiente, En caso de fallar retorna False.
	 * @param String $fecha
	 * @param String $hora
	 * @return \DateTime con la fecha y hora pasadas por parametro.
	 */
	public static function construirDatetime($fecha,$hora= null){

		if($hora){
			// Normalizando la hora.
			$descompHora =  explode(':',$hora);
			switch (count($descompHora)){
				case 1:
					$hora .= ':00:00';
					break;
				case 2:
					$hora .= ':00';
					break;
				default:
					break;
					
			}
		}else{
			$hora = '00:00:00';
		}
		
		// Para comprobar que sea una fecha valida intento contruir un Object DateTime, si es posible entonces retorno $newDate
		try {
			
			$newDate = $fecha.' '.$hora;
			if (empty(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fecha))) {
				$newDate = self::convertir($fecha).' '.$hora;
			}
			
			$testDateTime = new \DateTime($newDate);
			
		}catch(\Exception $e){
			// Si falla intengo convertir el formato de fecha para volver a intentar, si falla retorno false;
			try{
				// convierto la fecha en timestamp y luego la formateo para que respete el formato 'Y-m-d'
				$newDate = self::convertir($fecha).' '.$hora;
				$testDateTime = new \DateTime($newDate);
			}catch (\Exception $e){
				return false;
			}
		}

		return $newDate;
	}	
}

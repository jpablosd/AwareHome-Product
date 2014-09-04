package cl.awarehome.aplicacion.conexion;

/**
 * @author juanpablo
 *
 *Esta clase retorna los datos del servidor a todas las demas clases para la conexion al servidor,
 *ya sea ip del servidor y urls de todos los modulos correspondientes a la aplicación
 *
 *fecha de modificacion: 23-agosto-2014
 */

public class DatosServidor{

	public static String IpServidor(){
		String ip_servidor = "http://192.168.0.9";
		return ip_servidor;
	}
	
	public static String UrlLogin(){
		String url_login = "/servidor/acces/Login.php";
		return url_login;
	}
	
	public static String UrlDatos(){
		String url_datos = "/servidor/datos/Datos.php";
		return url_datos;
	}
	
	public static String UrlCrearReglas(){
		String url_crear_reglas = "/servidor/reglas/CreacionDeReglas.php";
		return url_crear_reglas;
	}
	
	public static String UrlMonitoreoDeReglas(){
		String url_monitoreo_de_reglas = "/servidor/reglas/MonitoreoDeReglas.php";
		return url_monitoreo_de_reglas;
	}
}//datosServidor
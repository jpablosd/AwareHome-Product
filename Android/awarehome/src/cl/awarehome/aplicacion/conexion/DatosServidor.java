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
		String ip_servidor = "http://54.148.163.167/";
		return ip_servidor;
	}

	public static String UrlLogin(){
		String url_login = "/AwareHome-Product/awarehome/acces/Login.php";
		return url_login;
	}

	public static String UrlDatos(){
		String url_datos = "/AwareHome-Product/awarehome/datos/Datos.php";
		return url_datos;
	}

	public static String UrlCrearAlerta(){
		String url_crear_reglas = "/AwareHome-Product/awarehome/alertas/CreacionDeAlertas.php";
		return url_crear_reglas;
	}

	public static String UrlMonitoreoDeAlertas(){
		String url_monitoreo_de_reglas = "/AwareHome-Product/awarehome/alertas/MonitoreoDeAlertas.php";
		return url_monitoreo_de_reglas;
	}
	
	public static String UrlDatosUsuario(){
		String url_datos_usuario = "/AwareHome-Product/awarehome/usuario/Usuario.php";
		return url_datos_usuario;
	}
	
	public static String UrlAgregarHogar(){
		String url_datos_usuario = "/AwareHome-Product/awarehome/hogar/CreacionDeHogar.php";
		return url_datos_usuario;
	}
}//datosServidor
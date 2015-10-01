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
		//String ip_servidor = "http://54.148.163.167/";
      // String ip_servidor = "http://190.153.212.77/";
       // String ip_servidor = "http://192.168.1.101/";
        //String ip_servidor = "http://192.168.1.158/";
        String ip_servidor = "http://www.awarehome.cl/";

		return ip_servidor;
	}

	public static String UrlLogin(){
	//	String url_login = "/AwareHome-Product/awarehome/acces/Login.php";
        //String url_login = "/proyectos/awarehome/acces/Login.php";

        String url_login = "/app/android/acces/Login.php";

        
        return url_login;
	}

	public static String UrlDatos(){
	//	String url_datos = "/AwareHome-Product/awarehome/datos/Datos.php";
       // String url_datos = "/proyectos/awarehome/datos/Datos.php";
        String url_datos = "/app/android/datos/Datos.php";

        return url_datos;
	}

	public static String UrlCrearAlerta(){
	//	String url_crear_reglas = "/AwareHome-Product/awarehome/alertas/CreacionDeAlertas.php";
      //String url_crear_reglas = "/proyectos/awarehome/alertas/CreacionDeAlertas.php";

       String url_crear_reglas = "/app/android/alertas/CreacionDeAlertas.php";

        return url_crear_reglas;
	}

	public static String UrlMonitoreoDeAlertas(){
      //  String url_monitoreo_de_reglas = "/AwareHome-Product/awarehome/alertas/verActualizarAlertas.php";
       // String url_monitoreo_de_reglas = "/proyectos/awarehome/alertas/verActualizarAlertas.php";

       String url_monitoreo_de_reglas = "/app/android/alertas/verActualizarAlertas.php";
        return url_monitoreo_de_reglas;
	}
	
	public static String UrlDatosUsuario(){
	//	String url_datos_usuario = "/AwareHome-Product/awarehome/usuario/Usuario.php";
      // String url_datos_usuario = "/proyectos/awarehome/usuario/Usuario.php";

        
        String url_datos_usuario = "/app/android/usuario/Usuario.php";

        return url_datos_usuario;
	}
	
	public static String UrlAgregarHogar(){
		String url_datos_usuario = "/AwareHome-Product/awarehome/hogar/CreacionDeHogar.php";
		return url_datos_usuario;
	}
}//datosServidor
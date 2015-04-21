package cl.awarehome.aplicacion.vista;



import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.splunk.mint.Mint;




import cl.awarehome.aplicacion.conexion.*;
import cl.awarehome.aplicacion.vista.Datos.DatosUsuario;
import cl.awarehome.aplicacion.R;
import android.app.Activity;
import android.app.ListActivity;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.RemoteViews;
import android.widget.SimpleAdapter;
import android.widget.Toast;

public class VerAlertas extends ListActivity {
	// Progress Dialog
	private ProgressDialog pDialog;
	// Creating JSON Parser object
	JSONParser jParser = new JSONParser();
	ArrayList<HashMap<String, String>> ListaDeAlertas;
	// url to get all empleados list Reemplaza la IP de tu equipo o la direccion de tu servidor 
	// Si tu servidor es tu PC colocar IP Ej: "http://127.97.99.200/taller06oct/..", no colocar "http://localhost/taller06oct/.."
	private static String url_alertas = DatosServidor.IpServidor() + DatosServidor.UrlMonitoreoDeAlertas();
	// JSON Node names
	private static final String TAG_SUCCESS = "success";
	private static final String TAG_alertas = "alertas";
	private static final String TAG_nombre_alerta = "nombre_alerta";
	private static final String TAG_estado = "estado";

	// empleados JSONArray
	JSONArray alertas = null;

	static final int codigo_noti = 1234;
	String estado_alerta;
	String nombre_alerta;
	
	String id_usuario = "0";

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.ver_alertas);

		Mint.initAndStartSession(VerAlertas.this, "d609afeb");
		
		Bundle extras = getIntent().getExtras();
		if (extras != null) {
            id_usuario  = extras.getString("id_usuario");//usuario
			Toast.makeText(getApplicationContext(), "id usuario: "+id_usuario, Toast.LENGTH_LONG).show();
		}else{
            id_usuario="error";
		}

		// Hashmap for ListView
		ListaDeAlertas = new ArrayList<HashMap<String, String>>();


		//Creamos el Timer
		Timer timer = new Timer();
		//Empezando des de el segundo 0
		timer.scheduleAtFixedRate(new TimerTask() {
			@Override
			public void run() {
				//La función que queremos ejecutar
				FuncionParaEsteHilo();
			}
		}, 0, 5000); //cada 5 segundos


	}//oncreate


	/*
	@Override
	protected void onStop(){
		Mint.closeSession(this);
	}
	 */


	private void FuncionParaEsteHilo()
	{
		//Esta función es llamada des de dentro del Timer
		//Para no provocar errores ejecutamos el Accion
		//Dentro del mismo Hilo
		this.runOnUiThread(Accion);
	}

	private Runnable Accion = new Runnable() {
		public void run() {
			//Aquí iría lo que queramos que haga,
			//en este caso mostrar un mensaje.
			//Toast.makeText(getApplicationContext(), "Tiempo!", Toast.LENGTH_LONG).show();
			ListaDeAlertas.clear();
			new CargarAlertas().execute();
		}
	};



	/**
	 * Background Async Task to Load all Empleado by making HTTP Request
	 * */
	class CargarAlertas extends AsyncTask<String, String, String> {

		/**
		 * Before starting background thread Show Progress Dialog
		 * */
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			//pDialog = new ProgressDialog(VerAlertas.this);
			//pDialog.setMessage("Cargando Alertas...");
			//pDialog.setIndeterminate(false);
			//pDialog.setCancelable(false);
			//pDialog.show();
		}

		/**
		 * getting All empleados from url
		 * */
		protected String doInBackground(String... args) {
			// Building Parameters
			List<NameValuePair> params = new ArrayList<NameValuePair>();
			params.add(new BasicNameValuePair("id_usuario", id_usuario));
            //Toast.makeText(getApplicationContext(), "agrega los parametros", Toast.LENGTH_LONG).show();

            // getting JSON string from URL
			JSONObject json = jParser.makeHttpRequest(url_alertas, "POST", params);

			// Check your log cat for JSON reponse
			Log.d("Alertas: ", json.toString());

			try {
                //Toast.makeText(getApplicationContext(), "entra al try", Toast.LENGTH_LONG).show();

                // Checking for SUCCESS TAG
				int success = json.getInt(TAG_SUCCESS);

				if (success == 1) {
					// empleados found
					// Getting Array of empleados
					alertas = json.getJSONArray(TAG_alertas);

					// looping through All empleados
					for (int i = 0; i < alertas.length(); i++) {
						JSONObject c = alertas.getJSONObject(i);

						// Storing each json item in variable
						estado_alerta = c.getString(TAG_estado);
						nombre_alerta = c.getString(TAG_nombre_alerta);



                        // creating new HashMap
						HashMap<String, String> map = new HashMap<String, String>();

						// adding each child node to HashMap key => value
						String nombre_estado = null;
						if (estado_alerta.equals("0")){
							nombre_estado = "desactivada";
							
						}

						if (estado_alerta.equals("1")){
							nombre_estado = "activada";
							
							triggerNotification();

						}
							
							
						

						map.put(TAG_estado, nombre_estado);
						map.put(TAG_nombre_alerta, nombre_alerta);

						// adding HashList to ArrayList
						ListaDeAlertas.add(map);
					}
				} else {
                    Toast.makeText(getApplicationContext(), "No hay alertas por ahora", Toast.LENGTH_LONG).show();

                    // no empleados found
					// Launch Add New Empleado Activity
					//Intent i = new Intent(getApplicationContext(),NewEmpladoActivity.class);
					// Closing all previous activities
					//i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
					//startActivity(i);
				}
			} catch (JSONException e) {
                //Toast.makeText(getApplicationContext(), "entra al catch", Toast.LENGTH_LONG).show();

                e.printStackTrace();
			}

			return null;
		}

		/**
		 * After completing background task Dismiss the progress dialog
		 * **/
		protected void onPostExecute(String file_url) {
			// dismiss the dialog after getting all empleados
			//pDialog.dismiss();
			// updating UI from Background Thread
			runOnUiThread(new Runnable() {
				public void run() {
					/**
					 * Updating parsed JSON data into ListView
					 * */



					ListAdapter adapter = new SimpleAdapter(VerAlertas.this, ListaDeAlertas,
							R.layout.list_item, new String[] { TAG_nombre_alerta, TAG_estado },
							new int[] { R.id.nombre_regla, R.id.estado_alerta });
					// updating listview
					setListAdapter(adapter);

				}
			});
		}
	}
	
	
	

	private void triggerNotification(){

		NotificationManager notificationManager = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);
		@SuppressWarnings("deprecation")
		Notification notification = new Notification(R.drawable.ic_launcher, "¡Nueva Alerta!", System.currentTimeMillis());
		notification.defaults = Notification.DEFAULT_ALL;

		RemoteViews contentView = new RemoteViews(getPackageName(), R.layout.notification_layout);
		contentView.setImageViewResource(R.id.img_notification, R.drawable.ic_launcher);
		contentView.setTextViewText(R.id.txt_notification, "Se Activo la alerta: " + nombre_alerta);

		notification.contentView = contentView;

		Intent notificationIntent = new Intent(this, VerAlertas.class);
		PendingIntent contentIntent = PendingIntent.getActivity(this, 0, notificationIntent, 0);
		notification.contentIntent = contentIntent;

		notificationManager.notify(codigo_noti, notification);
	}


}//class

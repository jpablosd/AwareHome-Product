package cl.awarehome.aplicacion.vista;



import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.apache.http.NameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;



import cl.awarehome.aplicacion.conexion.*;
import cl.awarehome.aplicacion.R;
import android.app.Activity;
import android.app.ListActivity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class VerAlertas extends ListActivity {
	// Progress Dialog
		private ProgressDialog pDialog;
		// Creating JSON Parser object
		JSONParser jParser = new JSONParser();
		ArrayList<HashMap<String, String>> ListaDeAlertas;
		// url to get all empleados list Reemplaza la IP de tu equipo o la direccion de tu servidor 
		// Si tu servidor es tu PC colocar IP Ej: "http://127.97.99.200/taller06oct/..", no colocar "http://localhost/taller06oct/.."
		private static String url_alertas = DatosServidor.IpServidor() + DatosServidor.UrlMonitoreoDeReglas();
		// JSON Node names
		private static final String TAG_SUCCESS = "success";
		private static final String TAG_alertas = "alertas";
		private static final String TAG_nombre_alerta = "nombre_regla";
		private static final String TAG_estado = "estado";
		

		// empleados JSONArray
		JSONArray alertas = null;
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.ver_alertas);
		
		// Hashmap for ListView
		ListaDeAlertas = new ArrayList<HashMap<String, String>>();
		// Loading empleados in Background Thread
		new CargarAlertas().execute();
		// Get listview
		ListView lv = getListView();
		
		
	}//oncreate
	
	
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
			pDialog = new ProgressDialog(VerAlertas.this);
			pDialog.setMessage("Cargando Alertas...");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(false);
			pDialog.show();
		}

		/**
		 * getting All empleados from url
		 * */
		protected String doInBackground(String... args) {
			// Building Parameters
			List<NameValuePair> params = new ArrayList<NameValuePair>();
			// getting JSON string from URL
			JSONObject json = jParser.makeHttpRequest(url_alertas, "POST", params);
			
			// Check your log cat for JSON reponse
			Log.d("Alertas: ", json.toString());

			try {
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
						String estado = c.getString(TAG_estado);
						String nombre = c.getString(TAG_nombre_alerta);
						

						// creating new HashMap
						HashMap<String, String> map = new HashMap<String, String>();

						// adding each child node to HashMap key => value
						
						map.put(TAG_estado, estado);
						map.put(TAG_nombre_alerta, nombre);
						
						// adding HashList to ArrayList
						ListaDeAlertas.add(map);
					}
				} else {
					// no empleados found
					// Launch Add New Empleado Activity
					//Intent i = new Intent(getApplicationContext(),NewEmpladoActivity.class);
					// Closing all previous activities
					//i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
					//startActivity(i);
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}

			return null;
		}

		/**
		 * After completing background task Dismiss the progress dialog
		 * **/
		protected void onPostExecute(String file_url) {
			// dismiss the dialog after getting all empleados
			pDialog.dismiss();
			// updating UI from Background Thread
			runOnUiThread(new Runnable() {
				public void run() {
					/**
					 * Updating parsed JSON data into ListView
					 * */
					ListAdapter adapter = new SimpleAdapter(VerAlertas.this, ListaDeAlertas,
							R.layout.list_item, new String[] { TAG_nombre_alerta },
							new int[] { R.id.nombre_regla });
					// updating listview
					setListAdapter(adapter);
				}
			});
		}
	}
	
	
}//class

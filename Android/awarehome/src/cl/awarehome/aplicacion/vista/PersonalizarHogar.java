package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cl.awarehome.aplicacion.R;
import cl.awarehome.aplicacion.conexion.DatosServidor;
import cl.awarehome.aplicacion.conexion.JSONParser;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class PersonalizarHogar extends Activity {

	EditText nombre_hogar;
	String nombreHogar;
	EditText descripcion_hogar;
	String descripcionHogar;
	Button agregar_direccion;
	Button agregar_hogar;
	String id_usuario_agregar_hogar, nombre_usuario;
	double latitud, longitud;


	JSONParser jsonParser = new JSONParser();
	// JSON Node names
	private static final String TAG_SUCCESS = "TAG_SUCCESS";

	String URL_connect = DatosServidor.IpServidor() + DatosServidor.UrlAgregarHogar();

	private ProgressDialog pDialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.personalizar_hogar);

		Bundle extras = getIntent().getExtras();
		if (extras != null) {
			id_usuario_agregar_hogar  = extras.getString("id_usuario");//usuario
			Toast.makeText(getApplicationContext(), "id_usuario: "+id_usuario_agregar_hogar, Toast.LENGTH_LONG).show();	
			nombre_usuario = extras.getString("usuario");
			Toast.makeText(getApplicationContext(), "nombre_usuario: "+nombre_usuario, Toast.LENGTH_LONG).show();	
			latitud = extras.getDouble("latitud");
			Toast.makeText(getApplicationContext(), "latitud: "+latitud, Toast.LENGTH_LONG).show();	
			longitud = extras.getDouble("longitud");
			Toast.makeText(getApplicationContext(), "longitud: "+longitud, Toast.LENGTH_LONG).show();	

		}else{
			id_usuario_agregar_hogar="error";
		}

		nombre_hogar = (EditText) findViewById(R.id.nombre_hogar);
		descripcion_hogar = (EditText) findViewById(R.id.descripcion_hogar);
		agregar_direccion = (Button) findViewById(R.id.agregar_direccion);
		agregar_hogar = (Button) findViewById(R.id.agregar_hogar);


		agregar_direccion.setOnClickListener(new View.OnClickListener() {			
			@Override
			public void onClick(View v) {
				Intent i=new Intent(PersonalizarHogar.this, AgregarHogar.class);
				i.putExtra("id_usuario",id_usuario_agregar_hogar);
				i.putExtra("usuario", nombre_usuario);
				startActivity(i); 
				finish();
			}
		});


		agregar_hogar.setOnClickListener(new View.OnClickListener() {			
			@Override
			public void onClick(View v) {

				nombreHogar = nombre_hogar.getText().toString();
				descripcionHogar = descripcion_hogar.getText().toString();
				//id usuario
				//Latitud
				//Longitud

				Toast.makeText(getApplicationContext(), "Hogar Agregado ", Toast.LENGTH_LONG).show();
				Intent i=new Intent(PersonalizarHogar.this, Datos.class);
				i.putExtra("usuario", nombre_usuario);
				startActivity(i);
				finish();

			}
		});
	}//onCreate
	/**
	 * Background Async Task to Create new Empleado
	 * */
	class AgregarHogarNuevo extends AsyncTask<String, String, String> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(PersonalizarHogar.this);
			pDialog.setMessage("Registrando hogar..");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(true);
			pDialog.show();
		}
		/**
		 * Creating Empleado
		 * */
		protected String doInBackground(String... args) {
			// Building Parameters
			List<NameValuePair> params = new ArrayList<NameValuePair>();
			//params.add(new BasicNameValuePair("descripcion", nombre_usuario));
			params.add(new BasicNameValuePair("latitud", Double.toString(latitud)));
			params.add(new BasicNameValuePair("longitud", Double.toString(longitud)));
			params.add(new BasicNameValuePair("id_usuario", id_usuario_agregar_hogar));
			// getting JSON Object
			// Note that create Empleado url accepts POST method

			JSONObject json = jsonParser.makeHttpRequest(URL_connect,"POST", params);
			JSONArray json2 = new JSONArray();
			// check for success tag
			try {
				int success = json.getInt(TAG_SUCCESS);

				if (success == 1) 
				{

				} 
				else {
					// failed to create Empleado
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}
			// check log cat fro response
			//Log.d("Create Response", json.toString());
			return null;
		}
		/**
		 * After completing background task Dismiss the progress dialog
		 * **/
		protected void onPostExecute(String file_url) {
			// dismiss the dialog once done
			pDialog.dismiss();
			Toast.makeText(getApplicationContext(), "Hogar Agregado", Toast.LENGTH_LONG).show();
			//finish();
		}
	}
	//-------------------------------------------------------------

}//PersonalizarHogar

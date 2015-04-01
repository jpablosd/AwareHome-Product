package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.splunk.mint.Mint;





import cl.awarehome.aplicacion.R;
import cl.awarehome.aplicacion.conexion.*;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Vibrator;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.Toast;

public class CrearAlerta extends Activity {

	EditText nombre_alerta, simbolo_alerta, dato_alerta;
	RadioButton sensor_temp, sensor_hum, sensor_gas;
	Button crear_alerta;

	boolean sensorTemperatura;
	boolean sensorHumedad;
	boolean sensorGas;
	String sensor;
	String nombreAlerta;
	String simboloAlerta;
	String datoAlerta;
	String id_usuario = "1";
	String id_sensor = "1";

	JSONParser jsonParser = new JSONParser();
	// JSON Node names
	private static final String TAG_SUCCESS = "TAG_SUCCESS";

	String URL_connect = DatosServidor.IpServidor() + DatosServidor.UrlCrearReglas();
	private ProgressDialog pDialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.creacion_de_reglas);

		Mint.initAndStartSession(CrearAlerta.this, "d609afeb");


		nombre_alerta = (EditText) findViewById(R.id.nombre_alerta);
		simbolo_alerta = (EditText) findViewById(R.id.simbolo_regla);
		dato_alerta = (EditText) findViewById(R.id.dato_regla);
		crear_alerta = (Button) findViewById(R.id.crear);

		sensor_hum = (RadioButton) findViewById(R.id.humedad);
		sensor_temp = (RadioButton) findViewById(R.id.sensor_tempa);
		sensor_gas = (RadioButton) findViewById(R.id.gas);


		sensor_temp.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener(){
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				// Código a ejecutar cuando el checbox está marcado
				sensorTemperatura = sensor_temp.isChecked();
				if (sensorTemperatura == true)
				{
					Toast.makeText(getApplicationContext(), "temperatura chequed", Toast.LENGTH_LONG).show();
					sensor_hum.setChecked(false);
					sensor_gas.setChecked(false);
					sensor = "temperatura";

				}else
				{
					Toast.makeText(getApplicationContext(), "temperatura no checked", Toast.LENGTH_LONG).show();
				}
			}
			public void onCheckedChanged1(CompoundButton buttonView,boolean isChecked) {
			}
		});

		sensor_hum.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener(){
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				// Código a ejecutar cuando el checbox está marcado
				sensorHumedad = sensor_hum.isChecked();
				if (sensorHumedad == true)
				{
					Toast.makeText(getApplicationContext(), "humedad chequed", Toast.LENGTH_LONG).show();
					sensor_temp.setChecked(false);
					sensor_gas.setChecked(false);
					sensor = "humedad";
				}else
				{
					Toast.makeText(getApplicationContext(), "humedad no checked", Toast.LENGTH_LONG).show();
				}
			}
			public void onCheckedChanged1(CompoundButton buttonView,boolean isChecked) {
			}
		});
		sensor_gas.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener(){
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				// Código a ejecutar cuando el checbox está marcado
				sensorGas = sensor_gas.isChecked();
				if (sensorGas == true)
				{
					Toast.makeText(getApplicationContext(), "gas chequed", Toast.LENGTH_LONG).show();
					sensor_temp.setChecked(false);
					sensor_hum.setChecked(false);
					sensor = "gas";
				}else
				{
					Toast.makeText(getApplicationContext(), "gas no checked", Toast.LENGTH_LONG).show();
				}
			}
			public void onCheckedChanged1(CompoundButton buttonView,boolean isChecked) {
			}
		});

		/*		sensor_temperatura.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener(){
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				// Código a ejecutar cuando el checbox está marcado
				sensorTemperatura = sensor_temperatura.isChecked();
				if (sensorTemperatura == true)
				{
					Toast.makeText(getApplicationContext(), "temperatura chequed", Toast.LENGTH_LONG).show();
					sensor_humedad.setChecked(false);
					sensor = "temperatura";
				}else
				{
					Toast.makeText(getApplicationContext(), "temperatura no checked", Toast.LENGTH_LONG).show();
				}
			}
			public void onCheckedChanged1(CompoundButton buttonView,boolean isChecked) {
			}
		});
		sensor_humedad.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener(){
			@Override
			public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
				// Código a ejecutar cuando el checbox está marcado
				sensorHumedad = sensor_humedad.isChecked();
				if (sensorHumedad == true)
				{
					Toast.makeText(getApplicationContext(), "humedad chequed", Toast.LENGTH_LONG).show();
					sensor_temperatura.setChecked(false);
					sensor = "humedad";
				}else
				{
					Toast.makeText(getApplicationContext(), "humedad no checked", Toast.LENGTH_LONG).show();
				}
			}
			public void onCheckedChanged1(CompoundButton buttonView,boolean isChecked) {
			}
		});
		 */		

		crear_alerta.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				//Toast.makeText(getApplicationContext(), "Aprete crear alerta", Toast.LENGTH_LONG).show();

				nombreAlerta = nombre_alerta.getText().toString();
				simboloAlerta = simbolo_alerta.getText().toString();
				datoAlerta = dato_alerta.getText().toString();

				//Toast.makeText(getApplicationContext(), "Nombre " + sensor, Toast.LENGTH_LONG).show();

				if(checkdata(nombreAlerta, simboloAlerta, datoAlerta, sensor ) == true){        			
					new CrearRegla().execute();				
					//enviarDatos(nombreAlerta, simboloAlerta, datoAlerta ,sensor, id_sensor, id_usuario);
				}else{
					err_data();
				}
			}
		});

	}//oncreate

	/*
	@Override
	protected void onStop(){
		Mint.closeSession(this);
	}
	 */


	//validamos si no hay ningun campo en blanco
	public boolean checkdata(String nombre ,String simbolo, String dato, String sensor){
		if 	(nombre.equals("") || simbolo.equals("") || dato.equals("") || sensor.equals("") ){
			Log.e("Crear Alerta Falsa", "Hay datos faltantes para la creacion de reglas.");
			return false;
		}else{
			return true;
		}
	} 
	//_______________________________________________________
	//vibra y muestra un Toast
	public void err_data(){
		Vibrator vibrator =(Vibrator) getSystemService(Context.VIBRATOR_SERVICE);
		vibrator.vibrate(200);
		Toast toast1 = Toast.makeText(getApplicationContext(),"Error: Datos Incorrectos.", Toast.LENGTH_SHORT);
		toast1.show();    	
	}
	//_______________________________________________________

	/**
	 * Background Async Task to Create new Empleado
	 * */
	class CrearRegla extends AsyncTask<String, String, String> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(CrearAlerta.this);
			pDialog.setMessage("Registrando Alerta..");
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
			params.add(new BasicNameValuePair("id_sensor", id_sensor));
			params.add(new BasicNameValuePair("id_usuario", id_usuario));
			params.add(new BasicNameValuePair("nombre_regla", nombreAlerta));
			params.add(new BasicNameValuePair("sensor", sensor));
			params.add(new BasicNameValuePair("simbolo", simboloAlerta));
			params.add(new BasicNameValuePair("dato", datoAlerta));
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
			Toast.makeText(getApplicationContext(), "Alerta Agregada", Toast.LENGTH_LONG).show();
			finish();
		}

	}


}//CrearAlerta

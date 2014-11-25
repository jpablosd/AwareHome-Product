package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.splunk.mint.Mint;

import cl.awarehome.aplicacion.R;
import cl.awarehome.aplicacion.conexion.*;

import android.animation.Animator;
import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.animation.Animator.AnimatorListener;
import android.animation.ValueAnimator.AnimatorUpdateListener;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class Datos extends Activity{

	int temperatura, humedad;
	int gas;
	String id_usuario_app = "0";
	String usuario, fecha_dato;

	//progress Dialog
	private ProgressDialog pDialog;
	//creating JSON parser object
	JSONParser jparser = new JSONParser();

	private static String url_all_empleados = DatosServidor.IpServidor() + DatosServidor.UrlDatos();
	private static String url_datos_usuario = DatosServidor.IpServidor() + DatosServidor.UrlDatosUsuario();

	//JSON node names
	private static final String TAG_SUCCESS = "success";
	private static final String TAG_DATOS = "datos";
	private static final String TAG_TEMPERATURA = "temperatura";
	private static final String TAG_HUMEDAD = "humedad";
	private static final String TAG_GAS = "gas";
	private static final String TAG_FECHA = "fecha";

	private static final String TAG_ID_USUARIO = "id_usuario";
	private static final String TAG_DATOS_USUARIO = "usuario";

	JSONArray empleados = null;
	JSONArray datos_usuario = null;

	private static final String TAG = Datos.class.getSimpleName();

	protected boolean mAnimationHasEnded = false;

	private TextView temp;
	private TextView hum;
	private TextView valor_gas;
	private TextView user;
	private TextView fecha;

	@Override
	protected void onCreate(final Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.datos);

		Mint.initAndStartSession(Datos.this, "d609afeb");

		user = (TextView) findViewById(R.id.usuario);

		Bundle extras = getIntent().getExtras();
		if (extras != null) {
			usuario  = extras.getString("usuario");//usuario
			user.setText(usuario);
			Toast.makeText(getApplicationContext(), "usuario: "+usuario, Toast.LENGTH_LONG).show();	

			new DatosUsuario().execute();

		}else{
			usuario="error";
		}

		temp = (TextView) findViewById(R.id.temperatura);
		hum = (TextView) findViewById(R.id.humedad);
		valor_gas = (TextView) findViewById(R.id.gas);
		fecha = (TextView) findViewById(R.id.fecha);

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
	}//onCreate

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
			new CargaDeDatos().execute();
		}
	};

	//Definimos que para cuando se presione la tecla BACK no volvamos para atras  	 
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event)  {
		if (keyCode == KeyEvent.KEYCODE_BACK && event.getRepeatCount() == 0) {
			// no hacemos nada.
			return true;
		}
		return super.onKeyDown(keyCode, event);
	}

	//--------------------------------------------------------
	class DatosUsuario extends AsyncTask<String, String, String>{
		@Override
		protected void onPreExecute(){
			super.onPreExecute();
			/*
					pDialog = new ProgressDialog(CircularProgressBarSample.this);
					pDialog.setMessage("cargando direccion");
					pDialog.setIndeterminate(false);
					pDialog.setCancelable(false);
					pDialog.show();
			 */
		}
		@Override
		protected String doInBackground(String... params) {
			//building parameters	
			List<NameValuePair> params2 = new ArrayList<NameValuePair>();
			params2.add(new BasicNameValuePair("usuario", usuario));
			//getting JSON string from URL
			JSONObject json = jparser.makeHttpRequest(url_datos_usuario,"POST", params2);
			//checj your log cat for JSON response
			Log.d("todas los datos: ", json.toString());

			try{
				//checking for success tag
				int success = json.getInt(TAG_SUCCESS);
				if(success == 1){
					//empleados found
					datos_usuario = json.getJSONArray(TAG_DATOS_USUARIO);
					//looping through all empleados
					for(int i=0; i<datos_usuario.length();i++){
						JSONObject c = datos_usuario.getJSONObject(i);
						//storig each json item in variable
						id_usuario_app = c.getString(TAG_ID_USUARIO);
					}
				}else{
					/*
						//no empleados found
						Intent i = new Intent(getApplicationContext(),Datos.class);
						//closing all previus activities
						i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
						startActivity(i);
					 */
				}
			}catch(JSONException e){
				e.printStackTrace();
			}
			return null;
		}//doInBackground

		protected void onPostExecute(String file_url){
			//dismiss the dialog after getting all empleados

			//pDialog.dismiss();
			Toast.makeText(getApplicationContext(), "Id usuario: "+id_usuario_app, Toast.LENGTH_LONG).show();	
		}
	}//Carda de datos usuaro
	//--------------------------------------------------------

	//--------------------------------------------------------
	class CargaDeDatos extends AsyncTask<String, String, String>{
		@Override
		protected void onPreExecute(){
			super.onPreExecute();
			/*
			pDialog = new ProgressDialog(CircularProgressBarSample.this);
			pDialog.setMessage("cargando direccion");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(false);
			pDialog.show();
			 */
		}
		@Override
		protected String doInBackground(String... params) {
			//building parameters	
			List<NameValuePair> params1 = new ArrayList<NameValuePair>();
			params1.add(new BasicNameValuePair("buscar", id_usuario_app));
			//getting JSON string from URL
			JSONObject json = jparser.makeHttpRequest(url_all_empleados,"POST", params1);
			//checj your log cat for JSON response
			Log.d("todas los datos: ", json.toString());

			try{
				//checking for success tag
				int success = json.getInt(TAG_SUCCESS);
				if(success == 1){
					//empleados found
					empleados = json.getJSONArray(TAG_DATOS);
					//looping through all empleados
					for(int i=0; i<empleados.length();i++){
						JSONObject c = empleados.getJSONObject(i);
						//storig each json item in variable
						temperatura = c.getInt(TAG_TEMPERATURA);
						humedad = c.getInt(TAG_HUMEDAD);
						gas = c.getInt(TAG_GAS);
						fecha_dato = c.getString(TAG_FECHA);
					}
				}else{
					//no datos found
					
					//Intent i = new Intent(getApplicationContext(),Datos.class);
					//closing all previus activities
					//i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
					//startActivity(i);
					
					new CargaDeDatos().execute();
				}
			}catch(JSONException e){
				e.printStackTrace();
			}
			return null;
		}//doInBackground
		protected void onPostExecute(String file_url){
			//dismiss the dialog after getting all empleados
			//pDialog.dismiss();
			//Toast.makeText(getApplicationContext(), "temperatura: "+temperatura+ "humedad: "+humedad, Toast.LENGTH_LONG).show();
			String t = String.valueOf(temperatura);
			temp.setText(t+"ºC");
			String h = String.valueOf(humedad);
			hum.setText(h+"%");
			String g = String.valueOf(gas);
			valor_gas.setText(g);
			fecha.setText(fecha_dato);
			//float lat = Float.parseFloat(lati);	
		}
	}//CargaDeDatos
	//--------------------------------------------------------

	@Override
	public boolean onCreateOptionsMenu(Menu menu) 
	{
		MenuInflater inflater = getMenuInflater();
		inflater.inflate(R.menu.menu_datos, menu);
		return true;
	}
	@Override
	public boolean onOptionsItemSelected(MenuItem item) 
	{
		switch (item.getItemId()) 
		{
		case R.id.Opc1:
			//crear alerta
			Toast.makeText(getApplicationContext(), "Crear alerta", Toast.LENGTH_LONG).show();
			Intent a=new Intent(Datos.this, CrearAlerta.class);
            a.putExtra("id_usuario",id_usuario_app);
            a.putExtra("nombre_usuario", usuario);
			startActivity(a);
			//finish();
			return true;

		case R.id.Opc2:
			Toast.makeText(getApplicationContext(), "Monitorear alerta", Toast.LENGTH_LONG).show(); 
			Intent b=new Intent(Datos.this, VerAlertas.class);
			b.putExtra("id_usuario",id_usuario_app);
			b.putExtra("nombre_usuario", usuario);
			startActivity(b);
			//finish();
			return true;

		case R.id.Opc3:	            	
			//cerrar  sesion nos regresa a la ventana anterior. 
			Toast.makeText(getApplicationContext(), "Cerrando Sesion de "+usuario, Toast.LENGTH_LONG).show();
			Intent c=new Intent(Datos.this, Login.class);
			startActivity(c);
			finish();
			return true;

        case R.id.Opc4:
             //cerrar  sesion nos regresa a la ventana anterior.
             Toast.makeText(getApplicationContext(), "Agregando Hogar ", Toast.LENGTH_LONG).show();
             Intent d=new Intent(Datos.this, PersonalizarHogar.class);
             d.putExtra("id_usuario",id_usuario_app);
             Toast.makeText(getApplicationContext(), "id_usuario: "+id_usuario_app, Toast.LENGTH_LONG).show();	
             d.putExtra("usuario", usuario);
             Toast.makeText(getApplicationContext(), "usuario: "+usuario, Toast.LENGTH_LONG).show();
             startActivity(d);
             finish();
             return true;

		default:
			return super.onOptionsItemSelected(item);
		}
	}
	//--------- menu ----------------------------

}//class
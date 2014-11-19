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
import cl.awarehome.aplicacion.vista.Datos.DatosUsuario;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.Toast;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.GoogleMap.OnMarkerClickListener;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.splunk.mint.Mint;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class AgregarHogar extends FragmentActivity {
	
	JSONParser jsonParser = new JSONParser();
	// JSON Node names
	private static final String TAG_SUCCESS = "TAG_SUCCESS";

	String URL_connect = DatosServidor.IpServidor() + DatosServidor.UrlAgregarHogar();

	String id_usuario_agregar_hogar, nombre_usuario;
	private GoogleMap googleMap;
	double plong;
	double plat;

	private ProgressDialog pDialog;
	
	
	String longitud_app, latitud_app;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.agregar_hogar);
		Mint.initAndStartSession(AgregarHogar.this, "d609afeb");


		Bundle extras = getIntent().getExtras();
		if (extras != null) {
			id_usuario_agregar_hogar  = extras.getString("id_usuario");//usuario
			nombre_usuario = extras.getString("usuario");

		}else{
			id_usuario_agregar_hogar="error";
		}

		LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
		LocationListener ll = new mylocationlistener();
		lm.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, ll);

		MapFragment mapFragment = (MapFragment) getFragmentManager().findFragmentById(R.id.map);
		googleMap = mapFragment.getMap();
		googleMap.setMyLocationEnabled(true);
	}//oncreate

	//----------- mylocationlistener -------------------
	class mylocationlistener implements LocationListener{
		@Override
		public void onLocationChanged(Location arg0) {
			if(arg0 != null){
				plong = arg0.getLongitude();
				plat = arg0.getLatitude();
			}
			else{
				Toast toast1 = Toast.makeText(getApplicationContext(),"Error: Encienda el gps", Toast.LENGTH_SHORT);
				toast1.show();   
			}
		}
		@Override
		public void onProviderDisabled(String arg0) {
		}
		@Override
		public void onProviderEnabled(String arg0) {
		}
		@Override
		public void onStatusChanged(String arg0, int arg1, Bundle arg2) {
		}

	}
	//----------- mylocationlistener -------------------


	@Override
	public boolean onCreateOptionsMenu(Menu menu) 
	{
		MenuInflater inflater = getMenuInflater();
		inflater.inflate(R.menu.menu_agregar_hogar, menu);
		return true;
	}
	@Override
	public boolean onOptionsItemSelected(MenuItem item) 
	{
		switch (item.getItemId()) 
		{
		case R.id.Opc1:
			//crear alerta
			Toast.makeText(getApplicationContext(), "Agregando hogar", Toast.LENGTH_LONG).show();

			Toast.makeText(getApplicationContext(), " Latitud: "+plat, Toast.LENGTH_LONG).show();
			Toast.makeText(getApplicationContext(), "Longitud: "+plong, Toast.LENGTH_LONG).show();

			googleMap.addMarker(new MarkerOptions().position(new LatLng(plat, plong))
					.title("Mi Hogar").snippet(nombre_usuario));
			
			latitud_app = Double.toString(plat);
			longitud_app = Double.toString(plong);
			
			new AgregarHogarNuevo().execute();
			
			//finish();
			return true;
		default:
			return super.onOptionsItemSelected(item);
		}
	}
	//--------- menu ----------------------------

	

	/**
	 * Background Async Task to Create new Empleado
	 * */
	class AgregarHogarNuevo extends AsyncTask<String, String, String> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			pDialog = new ProgressDialog(AgregarHogar.this);
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
			params.add(new BasicNameValuePair("latitud", latitud_app));
			params.add(new BasicNameValuePair("longitud", longitud_app));
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


	

}//class

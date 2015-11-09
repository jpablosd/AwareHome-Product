package cl.awarehome.aplicacion.vista;

import java.util.ArrayList;
import java.util.List;

import cl.awarehome.aplicacion.R;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class AlertasPreestablecidas extends Activity {
	private Spinner lista_alertas_preestablecidas;
	private List<String> lista;
	String Lista;
	private TextView nombre_alerta_preestablecida;
	public String nombreAlertaPreestablecida, sensorAlertaPreestablecida, simboloAlertaPreestablecida,datoAlertaPreestablecida, id_usuario;
	private TextView sensor_alerta_preestablecida;
	private TextView simbolo_alerta_preestablecida;
	private TextView dato_alerta_preestablecida;
	private Button seleccionar_alerta_preestablecida;


	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.alertas_preestablecidas);
		AlertasPreestablecidas();
		
		Bundle extras = getIntent().getExtras();
        if (extras != null) {
            id_usuario  = extras.getString("id_usuario");//usuario
            Toast.makeText(getApplicationContext(), "id usuario: "+id_usuario, Toast.LENGTH_LONG).show();
        }else{
            id_usuario="error";
        }

		nombre_alerta_preestablecida = (TextView) findViewById(R.id.nombre_alerta_preestablecida);
		sensor_alerta_preestablecida = (TextView) findViewById(R.id.sensor_alerta_preestablecida);
		simbolo_alerta_preestablecida = (TextView) findViewById(R.id.simbolo_alerta_preestablecida);
		dato_alerta_preestablecida = (TextView) findViewById(R.id.dato_alerta_preestablecida);

		seleccionar_alerta_preestablecida = (Button) findViewById(R.id.seleccionar_alerta_preestablecida);
		seleccionar_alerta_preestablecida.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {

				Intent i=new Intent(AlertasPreestablecidas.this, CrearAlerta.class);
				startActivity(i); 
				i.putExtra("id_usuario", id_usuario);
				i.putExtra("nombreAlerta",nombreAlertaPreestablecida);
				i.putExtra("sensorAlerta",sensorAlertaPreestablecida);
				i.putExtra("simboloAlerta",simboloAlertaPreestablecida);
				i.putExtra("datoAlerta",datoAlertaPreestablecida);
				finish();
				/**
				aca fijarse cual alerta seleccione y mandarla por el intent
				*/
			}
		});

	}//onCreate

	private void AlertasPreestablecidas(){
		lista_alertas_preestablecidas = (Spinner) findViewById(R.id.lista_alertas_preestablecidas);
		lista = new ArrayList<String>();
		lista_alertas_preestablecidas = (Spinner) this.findViewById(R.id.lista_alertas_preestablecidas);
		lista.add("Seleccionar Alerta");
		lista.add("Alerta De Incendio");
		lista.add("Fuga De Gas");
		lista.add("Fuga De Agua");
		lista.add("Movimiento Detectado");
		ArrayAdapter<String> adaptador = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, lista);
		adaptador.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		lista_alertas_preestablecidas.setAdapter(adaptador);

		//  	L=lista.get(RESULT_OK);   
		if(lista.toArray().toString().equalsIgnoreCase("Alerta De Incendio") == true){
			Lista = "Alerta De Incendio";	
		}
		if(lista.toArray().toString().equalsIgnoreCase("Fuga De Gas") == true){
			Lista = "Fuga De Gas";		   
		}
		if(lista.toArray().toString().equalsIgnoreCase("Fuga De Agua") == true){
			Lista = "Fuga De Agua";		   
		}
		if(lista.toArray().toString().equalsIgnoreCase("Movimiento Detectado") == true){
			Lista = "Movimiento Detectado";		   
		}
		lista_alertas_preestablecidas.setOnItemSelectedListener(new OnItemSelectedListener() {
			@Override
			public void onItemSelected(AdapterView<?> arg0, View arg1, int arg2, long arg3) {
				//Toast.makeText(arg0.getContext(), "Seleccionado: " + arg0.getItemAtPosition(arg2).toString(), Toast.LENGTH_SHORT).show();
				if (arg0.getItemAtPosition(arg2).toString().equalsIgnoreCase("Alerta De Incendio")){
					Toast.makeText(arg0.getContext(), "Seleccionado: seleccione alerta de incendio", Toast.LENGTH_SHORT).show();
					nombre_alerta_preestablecida.setText("Alerta De Incendio");
					sensor_alerta_preestablecida.setText("Temperatura");
					simbolo_alerta_preestablecida.setText(">");
					dato_alerta_preestablecida.setText("50ºC");
					nombreAlertaPreestablecida="Alerta De Incendio";
					sensorAlertaPreestablecida="temperatura";
					simboloAlertaPreestablecida=">";
					datoAlertaPreestablecida="50";
				}
				if (arg0.getItemAtPosition(arg2).toString().equalsIgnoreCase("Fuga De Gas")){
					Toast.makeText(arg0.getContext(), "Seleccionado: seleccione Fuga De Gas", Toast.LENGTH_SHORT).show();
					nombre_alerta_preestablecida.setText("Fuga De Gas");
					sensor_alerta_preestablecida.setText("Gas");
					simbolo_alerta_preestablecida.setText(">");
					dato_alerta_preestablecida.setText("1000PPM");
					nombreAlertaPreestablecida="Fuga De Gas";
					sensorAlertaPreestablecida="gas";
					simboloAlertaPreestablecida=">";
					datoAlertaPreestablecida="1000";
				}
				if (arg0.getItemAtPosition(arg2).toString().equalsIgnoreCase("Fuga De Agua")){
					Toast.makeText(arg0.getContext(), "Seleccionado: seleccione Fuga De Agua", Toast.LENGTH_SHORT).show();
					nombre_alerta_preestablecida.setText("Fuga De Agua");
					sensor_alerta_preestablecida.setText("Humedad");
					simbolo_alerta_preestablecida.setText(">");
					dato_alerta_preestablecida.setText("60%");
					nombreAlertaPreestablecida="Fuga De Agua";
					sensorAlertaPreestablecida="humedad";
					simboloAlertaPreestablecida=">";
					datoAlertaPreestablecida="60";
				}
				if (arg0.getItemAtPosition(arg2).toString().equalsIgnoreCase("Movimiento Detectado")){
					Toast.makeText(arg0.getContext(), "Seleccionado: seleccione Movimiento Detectado", Toast.LENGTH_SHORT).show();
					nombre_alerta_preestablecida.setText("Movimiento Detectado");
					sensor_alerta_preestablecida.setText("Movimiento");
					simbolo_alerta_preestablecida.setText("=");
					dato_alerta_preestablecida.setText("True");
					nombreAlertaPreestablecida="Movimiento Detectado";
					sensorAlertaPreestablecida="movimiento";
					simboloAlertaPreestablecida="==";
					datoAlertaPreestablecida="1";
				}
				//al seleccionar algo, hacer un intent hacia crear alerta con los datos y hacer un finish a esta
			}
			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
			}
		});
	}//AlertasPreestablecidas


}

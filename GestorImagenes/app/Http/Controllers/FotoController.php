<?php namespace GestorImagenes\Http\Controllers;

use GestorImagenes\Album;
use GestorImagenes\Foto;
use Illuminate\Http\Request;
use GestorImagenes\Http\Requests\MostrarFotosRequest;
use GestorImagenes\Http\Requests\CrearFotoRequest;
use Carbon\Carbon;

class FotoController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex(MostrarFotosRequest $request){

		$id=$request->get('id');
		$album=Album::find($id);
		$fotos=$album->fotos;
		return view('fotos.mostrar',['fotos'=>$fotos,'id'=>$id]);
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getCrearFoto(Request $request)
	{
		$id=$request->get('id');
		return view('fotos.crear-foto',['id'=>$id]);
	}
	public function postCrearFoto(CrearFotoRequest $request)
	{
		$id=$request->get('id');
		$imagen=$request->file('imagen');
		$ruta='/img/';
		$nombre=sha1(Carbon::now()).".".$imagen->guessExtension();
		$imagen->move(getcwd().$ruta,$nombre);
		Foto::create(
			[
				'nombre'=>$request->get('nombre'),
				'descripcion'=>$request->get('descripcion'),
				'ruta'=>$ruta.$nombre,
				'album_id'=>$id,
			]

		);
		return redirect("/validado/fotos?id=$id")->with('creada','La foto ha sido subida');
	}
	public function getActualizarFoto()
	{
		return 'formulario de actualizar fotos';
	}
	public function postActualizarFoto()
	{
		return 'actualizar foto';
	}
	public function getEliminarFoto()
	{
		return 'formulario de eliminar fotos';
	}
	public function postEliminarFoto()
	{
		return 'eliminando foto';
	}
	public function missingMethod($parameters=array()){
		abort(404);
	}

}
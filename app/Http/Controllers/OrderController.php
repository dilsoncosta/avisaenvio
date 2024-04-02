<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
	private $orderService;

	public function __construct(OrderService $orderService)
	{
		$this->orderService = $orderService;
	}
	
	public function index(Request $request)
	{
		/*
		 // URL da página a ser raspada
		 $url = 'https://www.rastreadordepacotes.com.br/rastreio/jadlog/18112000650462';
		 //$url = 'https://www.rastreadordepacotes.com.br/rastreio/QR001135211BR';
		 
		 // Inicializando o cliente Guzzle
		 $client = new Client();

		 try {
				 // Fazendo a requisição GET para obter o conteúdo da página
				 $response = $client->request('GET', $url);

				 // Verificando se a requisição foi bem-sucedida
				 if ($response->getStatusCode() === 200) {
						 // Obtendo o conteúdo da resposta
						 $html = (string)$response->getBody();

						 // Criando o objeto Crawler usando o HTML obtido
						 $crawler = new Crawler($html);

						 // Encontrando a lista com a classe 'is-hidden-tablet'
						 $lista_de_eventos = $crawler->filter('ul.is-hidden-tablet')->first();
						// dd($lista_de_eventos);exit;
						 // Inicializando uma lista para armazenar os eventos
						 $eventos = [];

						 // Iterando sobre cada item da lista
						 $lista_de_eventos->filter('li.columns')->each(function (Crawler $evento) use (&$eventos) {
							
							$meses = [
								'Janeiro' => '01',
								'Fevereiro' => '02',
								'Março' => '03',
								'Abril' => '04',
								'Maio' => '05',
								'Junho' => '06',
								'Julho' => '07',
								'Agosto' => '08',
								'Setembro' => '09',
								'Outubro' => '10',
								'Novembro' => '11',
								'Dezembro' => '12',
						];
							
								 // Obtendo as informações de data, hora e descrição
								 $data = $evento->filter('span')->first()->text();
								 $partes = explode(' ', $data);

// Obtendo o mês em formato numérico
$mes = $meses[$partes[1]];

// Formatando a data para "Ano-Mês-Dia"
$data = $partes[2] . '-' . $mes . '-' . Str::padLeft($partes[0], 2, '0');

							
								
								 $hora = $evento->filter('span.has-text-grey-light')->first()->text();
								
								 $descricaoHtml = $evento->filter('div.column')->html();
								 $posicaoPrimeiroBr = strpos($descricaoHtml, '<br>');
								 if ($posicaoPrimeiroBr !== false) {
									
										 $descricao = trim(substr($descricaoHtml, $posicaoPrimeiroBr + 4)); // Adiciona 4 para ignorar o <br>
										 $descricao = str_replace(["\n", '"'], "", $descricao);
										 $descricao = str_replace(["\n", '"'], "", $descricao);
										 $descricao = str_replace('Ainda não recebeu o seu pacote? Clique <a href=https://www.rastreadordepacotes.com.br/blog/o-que-fazer/meu-pacote-esta-entregue-mas-nao-recebi.html>AQUI</a>.', "", $descricao);
										 $descricao =  rtrim($descricao, "<br>");
										 $descricao = preg_replace('/<br\s*\/?>/', "\n", $descricao);
										 // Substitui os próximos <br> ou <br/> por \n sem eliminar
										 
								 } else {
										 $descricao = ''; // Se não encontrar o primeiro <br>, define a descrição como vazia
								 }
								 

								 
								 
								 // Criando um array associativo para cada evento e adicionando à lista de eventos
								 $eventos[] = [
										 'data' => $data,
										 'hora' => $hora,
										 'descricao' => $descricao
								 ];
								 
						 });

						 // Retornando o JSON com os eventos
						 return response()->json($eventos);
				 } else {
						 return response()->json(['error' => 'Erro ao acessar a página.'], 500);
				 }
		 } catch (\Exception $e) {
				 return response()->json(['error' => $e->getMessage()], 500);
		 }
		 exit;
		 */
		$orders = $this->orderService->getAllOrders($request);
		
		if ($orders->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => OrderResource::collection($orders)->response()->getData(false)));
	}

	public function store(OrderRequest $request)
	{
		if($this->orderService->getExistedObject($request->object, $request->type_integration, 0, ''))
		{
			return response()->json(array("status" => "1", "message" => "OBJETO já cadastrado para a INTEGRAÇÃO selecionada!"), 400);
		}
		
		$this->orderService->storeOrder($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
	
	public function update(OrderRequest $request)
	{
		$order = $this->orderService->getOrderById($request->id);
		
		if(!$order)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		if($this->orderService->getExistedObject($request->object, $request->type_integration,1, $request->id))
		{
			return response()->json(array("status" => "1", "message" => "OBJETO já cadastrado para a INTEGRAÇÃO selecionada!"), 400);
		}
		
		$this->orderService->updateOrder($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$business = $this->orderService->getOrderById($request->id);
		
		if(!$business)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new OrderResource($business)));
	}
	
	public function destroy(Request $request)
	{
		$this->orderService->deleteOrders($request->ids);
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}

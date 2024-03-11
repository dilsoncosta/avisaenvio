<x-mail::message>
<p style="text-align: center;">Para concluir o seu registro, confirme os dados abaixo clicando no botão de confirmação.</p>
<br/>
<p><b style="color: #2d3748">Subdominio:</b> {{ $data->subdomain }}</p>
<p><b style="color: #2d3748">Username:</b> {{ $data->username }}</p>
<p><b style="color: #2d3748">Nome:</b> {{ $data->name_surname }}</p>
<p><b style="color: #2d3748">E-mail:</b> {{ $data->email }}</p>
<p><b style="color: #2d3748">Telefone:</b> {{ $data->phone }}</p>
<p><b style="color: #2d3748">WhatsApp:</b> {{ $data->whatsapp }}</p>
<x-mail::button :url="$data->url_button_confirm">
  CONFIRMAR
</x-mail::button>
</x-mail::message>

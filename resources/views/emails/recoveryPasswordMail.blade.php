<x-mail::message>
<p style="text-align:left;">Olá, {{ $data->name }} {{ $data->surname }},</p>
<p style="text-align:left;">Você solicitou uma alteração de senha.</p>
<p style="text-align:left;">Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.</p>
<x-mail::button :url="$data->url_button_recovery">
  RECUPERAR
</x-mail::button>
</x-mail::message>

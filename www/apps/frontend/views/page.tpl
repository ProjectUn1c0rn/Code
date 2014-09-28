<div class="container">
<h2>{{ $title }}</h2>
<p>{{ $content }}</p>
{{ IF $created }}<small>Page created {{ php::date('Y/m/d H:i:s',$created) }}, last update {{ php::date('Y/m/d H:i:s',$updated) }}</small>{{ END }}
</div>

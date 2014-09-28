<div class="container">
{{ BEGIN host }}
<div class="page-header">
  <h1>{{ $ip }} <small>{{ $hostname }}</small></h1>

  {{ IF $ports }}
  <small class="host-detail-header">
    Ports: {{ implodef("<span class=\"label label-default\">%s</span> ",$ports) }}
  </small>
  {{ END }}
  {{ IF $tags }}
  <small class="host-detail-header">
    Tags: {{ implodef("<span class=\"label label-default\">%s</span> ",$tags) }}
  </small>
  {{ END }}

</div>
 <ul class="timeline">
    {{ BEGIN leaks }}
    {{ IF $_first }}
    <li><div class="tldate">{{ php::date("M Y",$date)}}</div></li>
    {{ END }}
    <li{{ IF $_odd }} class="timeline-inverted"{{ END }}>
      <div class="tl-circ"></div>
      <div class="timeline-panel">
        <div class="tl-heading">
          <h4>{{ $type }} leak occured on port {{ $port }}</h4>
          <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Leaked {{ time2ago($date) }} ago - {{ php::date('Y-m-d H:i:s',$date) }}</small></p>
        </div>
        <div class="tl-body">
          <pre>{{ $data|escape }}</pre>
        </div>
      </div>
    </li>
    {{ END leaks }}
</ul>
{{ END host }}
</div>

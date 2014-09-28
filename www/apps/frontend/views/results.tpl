<div class="container">
<form method="get" action="/search">
<div class="input-group">
      <input type="text" class="form-control" name="q" id="q" placeholder="eg : 'port:3306 transactions', 'tag:heartbleed password' " value="{{ $term | escape }}">
      <span class="input-group-btn">
        <input class="btn btn-default" type="submit" value="Search">
      </span>
</div>
</form>
<h4>Found {{ $total }} results in {{ $took }} ms for "{{ $term | escape }}"</h4>
{{ BEGIN Results }}
<div class="well well-sm search-results">
<div class="row">
  <div class="col-md-2">
    <a href="/host/{{ $ip }}">
    	<strong class="ip">{{ $ip }}</strong>
    </a>
  </div>
  <div class="hostname col-md-4">
    <a href="/host/{{ $ip }}">
    {{ $hostname }}</a>
  </div>
  <div class="date col-md-2">
    {{ IF $updated }}<em>{{ php::date("Y/m/d H:i",$updated) }}</em>{{ END }}
  </div>
  <div class="tags col-md-4">
    Tags : 
    {{ implodef("<span class=\"label label-default\">%s</span> ",$tags) }}
  </div>
</div>
<div class="row">
	<div class="col-md-12"><strong>Open ports</strong> : {{ implodef('<span class="label label-default">%s</span> ',$ports) }}</div>
</div>
{{ IF $highlight }}
                <p>{{ implode(' ... ',$highlight) }}</p>
                {{ ELSE }}
                <p>
                {{ BEGIN leaks }}
                {{ cutEscapeString($data,200)  }}
                {{ END }}
                </p>
{{ END }}
</div>
{{ END Results }}
<div style="text-align: center;">
{{ getPaginationString($page,$total,$resultsPerPage,1,$currentSearchUrl,"&page=") }}
</div>
</div>

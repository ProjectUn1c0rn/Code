<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>{{ IF $page_title }}{{ $page_title | escape }} - {{ END }}Un1c0rn Exposed</title>
    <link rel="stylesheet" href="/3rdparty/bootstrap.slate.min.css?21">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">
          <strong>Un1c0rn Exposed</strong>
        </a>
      </div>
        <ul class="nav navbar-nav ">
         	<li><a href="/stats">Index statistics</a></li>
         	<li><a href="/thanks">News and thanks</a></li>
         	<li><a href="/help">How to search on Un1c0rn</a></li>
		 <li><a href="/donations"><strong>Donate</strong></a></li>
        </ul>

      </nav>
	{{ include($view) }}
</body>
</html>

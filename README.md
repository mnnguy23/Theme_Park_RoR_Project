# Theme_Park_RoR_Project

## Set up Process

### PHP

1. Create the php file: Example.php

2. This will load the html file to be viewed:

  `<?php
  
    include 'app/base.php';
    
    $twig = loadEnvironment();
    
    $template = $twig->load('example.html');
    
  ?>`
  
  The loadEnvironment() function is from the base.php.
  
  That's why you need the 'app/base.php'.
  
  $twig is the variable that will have the Twig_Environment loaded to it.
  
  $template will then load the html file.
  
  For example, $template = $twig->load('index.html');
  
  Whatever variables you have created and want loaded into the html file, you will echo it.
  
  Example: echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
  
  $msg is a message variable and $clearSession is a link that clears the session.
    
3. This will connect to the database:

  `<?php
  
    $isDevelopment = false;
    
    $db = loadDB($isDevelopment);
    
    will create the database connection.
  ?>`


### HTML

1. Create the html file: example.html and make sure the file is in the templates folder

2. Include {% extends "base.html" %} to have the html file inherit from the base.html

3. Include {% block title %} Login {% endblock %} to set the title of the web page.

4. {% block content %}

  Write your html code here...
  
  {% endblock %}
  
  this will create load all of the html code you have written
    
5. If you want to include logic to your code use

  {% for example in examples %}
  
  {% endfor %}

6. If you want to call the variable created in the php file that is a string

  {{ msg }}

<?php

/* index.html */
class __TwigTemplate_10f78ca4ba5c09360c76bca7cb6a7953c20940294a36eb1e9a79939e85723d53 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>twigger</title>
    <link rel=\"stylesheet\" href=\"assets/css/style.css\" />
</head>
<body>
    <h1>Hi ";
        // line 10
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "!</h1>
    <h2>You are ";
        // line 11
        echo twig_escape_filter($this->env, ($context["age"] ?? null), "html", null, true);
        echo " years old</h2>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 11,  30 => 10,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html", "/www/sites/TA_Code/wwwroot/templates/index.html");
    }
}

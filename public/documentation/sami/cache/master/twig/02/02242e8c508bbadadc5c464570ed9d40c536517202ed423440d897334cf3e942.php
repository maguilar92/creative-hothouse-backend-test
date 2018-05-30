<?php

/* classes.twig */
class __TwigTemplate_735fdb23ff0a945db1ef3f06b79531771a65f5ce48fb977934cddcf9ff57f5e1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate('layout/layout.twig', 'classes.twig', 1);
        $this->blocks = [
            'title'        => [$this, 'block_title'],
            'body_class'   => [$this, 'block_body_class'],
            'page_content' => [$this, 'block_page_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return 'layout/layout.twig';
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 2
        $context['__internal_3751095711e4a6500fc4fee6d1dee918845e45a992b195fc3950a04b551ca7fa'] = $this->loadTemplate('macros.twig', 'classes.twig', 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo 'All Classes | ';
        $this->displayParentBlock('title', $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = [])
    {
        echo 'classes';
    }

    // line 6
    public function block_page_content($context, array $blocks = [])
    {
        // line 7
        echo '    <div class="page-header">
        <h1>Classes</h1>
    </div>

    ';
        // line 11
        echo $context['__internal_3751095711e4a6500fc4fee6d1dee918845e45a992b195fc3950a04b551ca7fa']->macro_render_classes((isset($context['classes']) || array_key_exists('classes', $context) ? $context['classes'] : (function () {
            throw new Twig_Error_Runtime('Variable "classes" does not exist.', 11, $this->getSourceContext());
        })()));
        echo '
';
    }

    public function getTemplateName()
    {
        return 'classes.twig';
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return [55 => 11,  49 => 7,  46 => 6,  40 => 4,  33 => 3,  29 => 1,  27 => 2,  11 => 1];
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout/layout.twig\" %}
{% from \"macros.twig\" import render_classes %}
{% block title %}All Classes | {{ parent() }}{% endblock %}
{% block body_class 'classes' %}

{% block page_content %}
    <div class=\"page-header\">
        <h1>Classes</h1>
    </div>

    {{ render_classes(classes) }}
{% endblock %}
", 'classes.twig', 'phar:///var/www/html/sami.phar/Sami/Resources/themes/default/classes.twig');
    }
}

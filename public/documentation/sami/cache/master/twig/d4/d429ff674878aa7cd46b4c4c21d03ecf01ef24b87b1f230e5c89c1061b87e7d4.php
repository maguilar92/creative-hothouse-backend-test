<?php

/* traits.twig */
class __TwigTemplate_7f06ef3020c2a4cd0892bd209d4e94917b633c6044836fd9e0619fe781fca1c5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate('layout/layout.twig', 'traits.twig', 1);
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
        $context['__internal_268d4e8876c07df7e71a21e43b6c1e338d655b66146e59d4e0e71c44f14947c1'] = $this->loadTemplate('macros.twig', 'traits.twig', 2);
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo 'Traits | ';
        $this->displayParentBlock('title', $context, $blocks);
    }

    // line 4
    public function block_body_class($context, array $blocks = [])
    {
        echo 'traits';
    }

    // line 6
    public function block_page_content($context, array $blocks = [])
    {
        // line 7
        echo '    <div class="page-header">
        <h1>Traits</h1>
    </div>

    <div class="container-fluid underlined">
        ';
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['classes']) || array_key_exists('classes', $context) ? $context['classes'] : (function () {
            throw new Twig_Error_Runtime('Variable "classes" does not exist.', 12, $this->getSourceContext());
        })()));
        foreach ($context['_seq'] as $context['_key'] => $context['class']) {
            // line 13
            echo '            ';
            if (twig_get_attribute($this->env, $this->getSourceContext(), $context['class'], 'trait', [])) {
                // line 14
                echo '                <div class="row">
                    <div class="col-md-6">
                        ';
                // line 16
                echo $context['__internal_268d4e8876c07df7e71a21e43b6c1e338d655b66146e59d4e0e71c44f14947c1']->macro_class_link($context['class'], true);
                echo '
                    </div>
                    <div class="col-md-6">
                        ';
                // line 19
                echo $this->env->getExtension('Sami\Renderer\TwigExtension')->parseDesc($context, twig_get_attribute($this->env, $this->getSourceContext(), $context['class'], 'shortdesc', []), $context['class']);
                echo '
                    </div>
                </div>
            ';
            }
            // line 23
            echo '        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['class'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo '    </div>
';
    }

    public function getTemplateName()
    {
        return 'traits.twig';
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return [86 => 24,  80 => 23,  73 => 19,  67 => 16,  63 => 14,  60 => 13,  56 => 12,  49 => 7,  46 => 6,  40 => 4,  33 => 3,  29 => 1,  27 => 2,  11 => 1];
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout/layout.twig\" %}
{% from \"macros.twig\" import class_link %}
{% block title %}Traits | {{ parent() }}{% endblock %}
{% block body_class 'traits' %}

{% block page_content %}
    <div class=\"page-header\">
        <h1>Traits</h1>
    </div>

    <div class=\"container-fluid underlined\">
        {% for class in classes %}
            {% if class.trait %}
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        {{ class_link(class, true) }}
                    </div>
                    <div class=\"col-md-6\">
                        {{ class.shortdesc|desc(class) }}
                    </div>
                </div>
            {% endif %}
        {% endfor %}
    </div>
{% endblock %}
", 'traits.twig', 'phar:///var/www/html/sami.phar/Sami/Resources/themes/default/traits.twig');
    }
}

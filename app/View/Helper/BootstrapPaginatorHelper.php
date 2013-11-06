<?php

App::uses('PaginatorHelper', 'View/Helper');

class BootstrapPaginatorHelper extends PaginatorHelper {

	public function numbers($options = array()) {
		$defaults = array(
			'size'     => null,
			'class'    => null,
			'modulus'  => '4',
			'ellipsis' => '...',
			'first'    => 'First', 
			'last'     => 'Last',
			'prev'     => '&laquo;',
			'next'     => '&raquo;',
			'model'    => $this->defaultModel(),
			'before'   => null,
			'after'    => null			
		);
		$options += $defaults;
		
		$params = (array)$this->params($options['model']) + array('page' => 1);
		unset($options['model']);		
		
		if ($params['pageCount'] <= 1) {
			return false;
		}
		
		extract($options);
		unset($options['model'], $options['modulus'], $options['first'], $options['last'], $options['prev'], $options['next'], $options['ellipsis'], $options['class']);		

		if ($class) {
			if (is_array($class)) {
				$class = implode(' ' , $class);
			}
			$class = ' ' . $class;
		}
		if ($options['size']) {
			$class .= ' pagination-' . $options['size'];
		}
		
		$out = '';
		if ($options['before']) {
			$out .= $options['before'];
		}		
		
		$out .= '<ul class="pagination'. $class .'">';

		if ($modulus && $params['pageCount'] > $modulus) {
			$half = intval($modulus / 2);
			$end = $params['page'] + $half;
	
			if ($end > $params['pageCount']) {
				$end = $params['pageCount'];
			}
			
			$start = $params['page'] - ($modulus - ($end - $params['page']));
	
			if ($start <= 1) {
				$start = 1;
				$end = $params['page'] + ($modulus - $params['page']) + 1;
			}
			
			if ($first && $start > 1) {
				$offset = ($start <= (int)$first) ? $start - 1 : $first;
				$out .= $this->first($offset, array('tag' => 'li', 'separator' => null, 'ellipsis' => null));
			}
			
			if ($prev) {
				$out .= $this->prev($prev, array('tag' => 'li', 'escape' => false), $prev, array('class' => 'prev disabled', 'tag' => 'li', 'disabledTag' => 'span', 'escape' => false));
			}
			
			for ($i = $start; $i < $params['page']; $i++) {
				$out .= $this->Html->tag('li', $this->link($i, array('page' => $i)));
			}			
		
			$out .= $this->Html->tag('li', $this->Html->tag('span', $params['page']), array('class' => 'active'));
			
			$start = $params['page'] + 1;
			for ($i = $start; $i < $end; $i++) {
				$out .= $this->Html->tag('li', $this->link($i, array('page' => $i)));
			}
			
			if ($end != $params['page']) {
				$out .= $this->Html->tag('li', $this->link($i, array('page' => $end)));
			}			
			
			if ($next) {
				$out .= $this->next($next, array('tag' => 'li', 'escape' => false), $next, array('class' => 'prev disabled', 'tag' => 'li', 'disabledTag' => 'span', 'escape' => false));
			}
						
			if ($last && $end < $params['pageCount']) {
				$offset = ($params['pageCount'] < $end + (int)$last) ? $params['pageCount'] - $end : $last;
				$out .= $this->last($offset, array('tag' => 'li', 'separator' => null, 'ellipsis' => null));
			}																	
		} else {
			if ($prev) {
				$out .= $this->prev($prev, array('tag' => 'li', 'escape' => false), $prev, array('class' => 'prev disabled', 'tag' => 'li', 'disabledTag' => 'span', 'escape' => false));
			}		
			for ($i = 1; $i <= $params['pageCount']; $i++) {
				if ($i == $params['page']) {
					$out .= $this->Html->tag('li', $this->Html->tag('span', $i), array('class' => 'active'));
				} else {
					$out .= $this->Html->tag('li', $this->link($i, array('page' => $i)));
				}
			}
			if ($next) {
				$out .= $this->next($next, array('tag' => 'li', 'escape' => false), $next, array('class' => 'prev disabled', 'tag' => 'li', 'disabledTag' => 'span', 'escape' => false));
			}			
		}
		
		$out .= '</ul>';
		if ($options['after']) {
			$out .= $options['after'];
		}
		
		return $out;
	}


}

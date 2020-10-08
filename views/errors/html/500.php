<?php

foreach ($dotFlatten($collection) as $class => $value) {
	echo '<p class="collection-' . str_replace('.', '-', $class) . '">' . $value . '</p>';
}

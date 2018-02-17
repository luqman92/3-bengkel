<?php

function format_angka($angka) {
	$hasil = number_format($angka,0, ",",".");
	return $hasil;
}
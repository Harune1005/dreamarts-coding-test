<?php

$adj = [];
while ($line = fgets(STDIN)) {
    $line = trim($line);
    if ($line === "") continue;
    
    $data = explode(',', $line);
    if (count($data) < 3) continue;

    $u = trim($data[0]);
    $v = trim($data[1]);
    $dist = (float)trim($data[2]);

    $adj[$u][] = ['to' => $v, 'dist' => $dist];
    $adj[$v][] = ['to' => $u, 'dist' => $dist];
}

$maxDist = -1.0;
$bestPath = [];

function findLongestPath($current, $visited, $currentDist, $path) {
    global $adj, $maxDist, $bestPath;

    if ($currentDist > $maxDist) {
        $maxDist = $currentDist;
        $bestPath = $path;
    }

    if (!isset($adj[$current])) return;

    foreach ($adj[$current] as $edge) {
        $next = $edge['to'];

        if (!in_array($next, $visited)) {
            $visited[] = $next;
            $path[] = $next;
            
            findLongestPath($next, $visited, $currentDist + $edge['dist'], $path);
            
            array_pop($visited);
            array_pop($path);
        }
    }
}

$stations = array_keys($adj);
foreach ($stations as $startNode) {
    findLongestPath($startNode, [$startNode], 0.0, [$startNode]);
}

if (!empty($bestPath)) {
    echo implode("\r\n", $bestPath) . "\r\n";
}
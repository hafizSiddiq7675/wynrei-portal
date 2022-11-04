<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        h1 {
  color: #c00;
  font-family: sans-serif;
  font-size: 2em;
  margin-bottom: 0;
}

table {
  font-family: sans-serif;
}
table th, table td {
  padding: 0.25em 0.5em;
  text-align: left;
}
table th:nth-child(2), table td:nth-child(2) {
  text-align: right;
}
table td {
  background-color: #eee;
}
table th {
  background-color: #009;
  color: #fff;
}

.zigzag {
  border-collapse: separate;
  border-spacing: 0.25em 1em;
}
.zigzag tbody tr:nth-child(odd) {
  transform: rotate(2deg);
}
.zigzag thead tr,
.zigzag tbody tr:nth-child(even) {
  transform: rotate(-2deg);
}
    </style>
</head>
<body>
    <h1>You have a new bid</h1>
    <span><b>Please check at</b>
        <a href="{{ $data['link'] }}" target="_blank">{{ $data['link'] }}</a>
    </span>


</body>
</html>

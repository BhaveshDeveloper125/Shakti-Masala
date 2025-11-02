<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <x-cdnlinks />
</head>
<body class="h-screen w-screen flex">
    <x-admin-menu />
    <div class="flex-1 bg-red-500">
      <form action="/add_costing" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $id }}">
        <input type="number" name="raw_material" id="raw_material" placeholder="Enter Raw Material Amount"> <br>
        <input type="number" name="labour" id="labour" placeholder="Enter Labour Amount"> <br>
        <input type="number" name="other_expense" id="other_expense" placeholder="Enter Other Expenses Amount"> <br>
        <input type="number" name="total_unit_produced" id="total_unit_produced" placeholder="Enter Number Product that are produced."> <br>
        <select name="product_type" id="product_type">
            <option selected disabled></option>
            @foreach ($ProductType as $i)
            <option value="{{ $i->name }}">{{ $i->name }}</option>
            @endforeach
        </select>
        <input type="submit" value="Add Costing">
    </form>

    </div>


</body>
</html>

{{-- <!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*{
			font-family: Arial, sans-serif;
		}

		.center{
			text-align: center;
		}

		.right{
			text-align: right;
		}

		.left{
			text-align: left;
		}

		p{
			font-size: 10px;
		}

		.top-min{
			margin-top: -10px;
		}

		.uppercase{
			text-transform: uppercase;
		}

		.bold{
			font-weight: bold;
		}

		.d-block{
			display: block;
		}

		hr{
			border: 0;
			border-top: 1px solid #000;
		}

		.hr-dash{
			border-style: dashed none none none;
		}

		table{
			font-size: 10px;
		}

		table thead tr td{
			padding: 5px;
		}

		.w-100{
			width: 100%;
		}

		.line{
			border: 0;
			border-top: 1px solid #000;
			border-style: dashed none none none;
		}

		.body{
			margin-top: -10px;
		}

		.b-p{
			font-size: 12px !important;
		}

		.w-long{
			width: 80px;
		}
	</style>
</head>
<body>
	<div class="header">
		<p class="uppercase bold d-block center b-p">{{ $market->nama_toko }}</p>
		<p class="top-min d-block center">{{ $market->alamat }}</p>
		<p class="top-min d-block center">{{ $market->no_telp }}</p>
		<hr class="hr-dash">
		<table class="w-100">
			<tr>
				<td class="left w-long">Kode Transaksi : </td>
				<td class="left">{{ $transaction->kode_transaksi }}</td>
				<td class="right">Kasir : </td>
				@php
				$nama_kasir = explode(' ', $transaction->kasir->nama);
				$kasir = $nama_kasir[0];
				@endphp
				<td class="right">{{ $kasir }}</td>
			</tr>
			<tr>
				<td></td>
				<td class="left" colspan="3">{{ date('d M, Y', strtotime($transaction->created_at)) }}</td>
			</tr>
		</table>
		<hr class="hr-dash">
	</div>
	<div class="body">
		<table class="w-100">
			<thead>
				<tr>
					<td>Nama Barang</td>
					<td>Qty</td>
					<td>Harga</td>
					<td>Jumlah</td>
				</tr>
				<tr>
					<td colspan="4" class="line"></td>
				</tr>
			</thead>
			<tbody>
				@foreach($items as $transaksi)
				<tr>
					<td>{{ $transaksi->product->nama_barang }}</td>
					<td>{{ $transaksi->total_barang }}</td>
					<td>{{ number_format($transaksi->product->harga_jual,2,',','.') }}</td>
					<td>{{ number_format($transaksi->subtotal,2,',','.') }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<hr class="hr-dash">
		<table class="w-100">
			<tr>
				<td class="left">Subtotal (Jumlah : {{ $items->count() }})</td>
				<td class="right">{{ number_format($transaction->total_harga,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="left">Diskon ({{ $transaction->diskon }}%)</td>
				<td class="right">{{ number_format($diskon,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="left">Total</td>
				<td class="right">{{ number_format($total,2,',','.') }}</td>
			</tr>
		</table>
		<hr class="hr-dash">
		<table class="w-100">
			<tr>
				<td class="left">Bayar</td>
				<td class="right">{{ number_format($transaction->bayar,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="left">Kembali</td>
				<td class="right">{{ number_format($transaction->kembali,2,',','.') }}</td>
			</tr>
		</table>
		<hr class="hr-dash">
	</div>
	<div class="footer">
		<p class="center">Terima Kasih Telah Berkunjung</p>
	</div>
</body>
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        
        body {
            width: 58mm;
            padding: 5px;
        }
        
        .center {
            text-align: center;
        }
        
        .right {
            text-align: right;
        }
        
        .bold {
            font-weight: bold;
        }
        
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        td {
            padding: 2px 0;
        }
    </style>
</head>
<body>
    <div class="header center">
        <p class="bold">{{ $market->nama_toko }}</p>
        <p>{{ $market->alamat }}</p>
        <p>{{ $market->no_telp }}</p>
        <hr>
    </div>
    
    <div class="details">
        <table>
            <tr>
                <td>Kode:</td>
                <td class="right">{{ $transaction->kode_transaksi }}</td>
            </tr>
            <tr>
                <td>Kasir:</td>
                <td class="right">{{ explode(' ', $transaction->kasir->nama)[0] }}</td>
            </tr>
            <tr>
                <td>Tanggal:</td>
                <td class="right">{{ date('d M, Y', strtotime($transaction->created_at)) }}</td>
            </tr>
        </table>
        <hr>
    </div>
    
    <div class="items">
        <table>
            <tr class="bold">
                <td>Barang</td>
                <td class="right">Qty</td>
                <td class="right">Harga</td>
                <td class="right">Total</td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>
            </tr>
            @foreach($items as $transaksi)
            <tr>
                <td>{{ $transaksi->product->nama_barang }}</td>
                <td class="right">{{ $transaksi->total_barang }}</td>
                <td class="right">{{ number_format($transaksi->product->harga_jual, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
        <hr>
    </div>
    
    <div class="summary">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td class="right">{{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Diskon ({{ $transaction->diskon }}%):</td>
                <td class="right">{{ number_format($diskon, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td>Total:</td>
                <td class="right">{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bayar:</td>
                <td class="right">{{ number_format($transaction->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali:</td>
                <td class="right">{{ number_format($transaction->kembali, 0, ',', '.') }}</td>
            </tr>
        </table>
        <hr>
    </div>
    
    <div class="footer center">
        <p>Terima Kasih Telah Berkunjung</p>
    </div>
</body>
</html>

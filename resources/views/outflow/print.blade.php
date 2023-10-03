<!DOCTYPE>
<html >
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invoice</title>

  <style type="text/css">
    /* Take care of image borders and formatting, client hacks */
    img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }


    /* General styling */
    * {
      font-family: Helvetica, Arial, sans-serif;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      margin: 0 !important;
      height: 100%;
      color: #676767;
    }

    td {
      font-family: Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #777777;
      text-align: center;
      line-height: 21px;
    }

    a {
      color: #676767;
      text-decoration: none !important;
    }

    .pull-left {
      text-align: left;
    }

    .pull-right {
      text-align: right;
    }

    .header-lg,
    .header-md,
    .header-sm {
      font-size: 32px;
      font-weight: 700;
      line-height: normal;
      padding: 35px 0 0;
      color: #4d4d4d;
    }

    .header-md {
      font-size: 24px;
    }

    .header-sm {
      padding: 5px 0;
      font-size: 18px;
      line-height: 1.3;
    }

    .content-padding {
      padding: 20px 0 5px;
    }

    .mobile-header-padding-right {
      width: 290px;
      text-align: right;
      padding-left: 10px;
    }

    .mobile-header-padding-left {
      width: 290px;
      text-align: left;
      padding-left: 10px;
    }

    .free-text {
      width: 100% !important;
      padding: 10px 60px 0px;
    }

    .button {
      padding: 30px 0;
    }

    .mini-block {
      border: 1px solid #e5e5e5;
      border-radius: 5px;
      background-color: #ffffff;
      padding: 12px 15px 15px;
      text-align: left;
      width: 253px;
    }

    .mini-container-left {
      width: 278px;
      padding: 10px 0 10px 15px;
    }

    .mini-container-right {
      width: 278px;
      padding: 10px 14px 10px 15px;
    }

    .product {
      text-align: left;
      vertical-align: top;
      width: 175px;
    }

    .total-space {
      padding-bottom: 8px;
      display: inline-block;
    }

    .item-table {
      padding: 50px 20px;
      width: 560px;
    }

    .item {
      width: 300px;
    }

    .mobile-hide-img {
      text-align: left;
      width: 125px;
    }

    .mobile-hide-img img {
      border: 1px solid #e6e6e6;
      border-radius: 4px;
    }

    .title-dark {
      text-align: left;
      border-bottom: 1px solid #cccccc;
      color: #4d4d4d;
      font-weight: 700;
      padding-bottom: 5px;
    }

    .item-col {
      padding-top: 20px;
      text-align: left;
      vertical-align: top;
    }

    .force-width-gmail {
      min-width:600px;
      height: 0px !important;
      line-height: 1px !important;
      font-size: 1px !important;
    }

  </style>

  <style type="text/css" media="screen">
    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
  </style>

  <style type="text/css" media="screen">
    @media screen {
      /* Thanks Outlook 2013! */
      * {
        font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
      }
    }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class*="container-for-gmail-android"] {
        min-width: 290px !important;
        width: 100% !important;
      }

      img[class="force-width-gmail"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }

      table[class="w320"] {
        width: 320px !important;
      }

      td[class*="mobile-header-padding-left"] {
        width: 160px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-header-padding-right"] {
        width: 160px !important;
        padding-right: 0 !important;
      }

      td[class="header-lg"] {
        font-size: 24px !important;
        padding-bottom: 5px !important;
      }

      td[class="content-padding"] {
        padding: 5px 0 5px !important;
      }

       td[class="button"] {
        padding: 5px 5px 30px !important;
      }

      td[class*="free-text"] {
        padding: 10px 18px 30px !important;
      }

      td[class~="mobile-hide-img"] {
        display: none !important;
        height: 0 !important;
        width: 0 !important;
        line-height: 0 !important;
      }

      td[class~="item"] {
        width: 140px !important;
        vertical-align: top !important;
      }

      td[class~="quantity"] {
        width: 50px !important;
      }

      td[class~="price"] {
        width: 90px !important;
      }

      td[class="item-table"] {
        padding: 30px 20px !important;
      }

      td[class="mini-container-left"],
      td[class="mini-container-right"] {
        padding: 0 15px 15px !important;
        display: block !important;
        width: 290px !important;
      }

    }
  </style>
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="800" class="w320">
          <tr>
            <td class="header-lg" style="text-transform: uppercase">
              {{ getSettings()->proName }}
            </td>
          </tr>
          <tr>
            <td >
            <h4 style="text-transform: uppercase">Invoice</h4>
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td class="mini-container-left">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                <tr>
                                  <td class="mini-block">
                                    <span class="header-sm">To</span><br />
                                    {{ $bill->customer->title }}
                                    <br />
                                    <br />
                                    <span class="header-sm">Payment Status</span> <br />
                                    @if($bill->isPaid == "yes")
                                        Paid
                                    @elseif ($bill->isPaid == "no")
                                        Unpaid
                                    @else
                                        Partial
                                    @endif
                                  </td>
                                </tr>
                              </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Date</span><br />
                                {{ date("d M Y", strtotime($bill->date)); }}
                                <br />
                                <br />
                                <span class="header-sm">Order #</span> <br />
                                {{ $bill->id }}
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="800" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                       Product
                    </td>
                    <td class="title-dark" style="text-align: right" width="100">
                        Size
                      </td>
                    <td class="title-dark" style="text-align: right" width="150">
                      Quantity
                    </td>
                    <td class="title-dark" style="text-align: right" width="200">
                      Price
                    </td>
                    <td class="title-dark" style="text-align: right" width="200">
                        Amount
                      </td>
                  </tr>
                  @php
                      $amount = 0;
                      $total = 0;
                  @endphp
                  @foreach ($bill->details as $items)
                  @php
                       if($items->unit == "Piece")
                        {
                            $amount = $items->sqf * $items->qty * $items->price;
                        }
                        else {
                            $amount = $items->qty * $items->price;
                        }
                      $total += $amount;
                  @endphp
                  <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                            <img width="110" height="92" src="{{ asset($items->product->img) }}" alt="item1">
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight:bold;">Code: {{ $items->product->code }}</span> <br />
                            {{ $items->product->color }}
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col" style="text-align: right">
                        {{ round($items->width,0) }} x {{ round($items->length,0) }} <br>({{ round($items->sqf,2) }} Sqf)
                      </td>
                    <td class="item-col" style="text-align: right">
                      {{ round($items->qty,2) }} / {{ $items->unit }} <br/>({{ $items->sqf * $items->qty }} T-Sqf)
                    </td>
                    <td class="item-col" style="text-align: right">
                     {{ $items->price }}
                    </td>
                    <td class="item-col" style="text-align: right">
                        {{ round($amount,2) }}
                       </td>
                  </tr>
                  @endforeach
                  @php
                      $discount = $bill->discount;
                      $g_total = $total - $discount;
                      $remaining = $g_total - $bill->amountPaid;
                  @endphp

                  <tr>
                    <td class="" colspan="3">
                    </td>
                    <td class="" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="">Total</span> <br />
                    </td>
                    <td class="" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span class=""> {{ round($total, 2) }}</span> <br />
                    </td>
                  </tr>
                  @if($bill->discount > 0)
                  <tr>
                    <td class="" colspan="3">
                    </td>
                    <td class="" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span>Discount</span> <br />
                    </td>
                    <td class="" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span>{{ round($discount,2) }}</span> <br />
                    </td>
                  </tr>
                  <tr>
                    <td class="" colspan="3">
                    </td>
                    <td class="" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span>G. Total</span> <br />
                    </td>
                    <td class="" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span>{{ round($g_total,2) }}</span> <br />
                    </td>
                  </tr>
                  @endif
                  @if($bill->isPaid == "partial")
                  <tr>
                    <td class="" colspan="3">
                    </td>
                    <td class="" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="">Amount Paid</span> <br />
                    </td>
                    <td class="" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span class="">{{ round($bill->amountPaid,2) }}</span> <br />
                    </td>
                  </tr>
                  <tr>
                    <td class="" colspan="3">
                    </td>
                    <td class="" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="">Remaining</span> <br />
                    </td>
                    <td class="" style="text-align: right; border-top: 1px solid #cccccc;">
                      <span class="">{{ round($remaining,2) }}</span> <br />
                    </td>
                  </tr>
                  @endif
                </table>
              </td>
            </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td style="padding: 25px 0 25px">
             {{--  <strong>Software Developed By</strong><br />
                <a href="#">Smart IT Solutions</a> <br /> --}}
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>
</div>
</body>
</html>

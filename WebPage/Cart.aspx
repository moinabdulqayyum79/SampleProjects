<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Cart.aspx.cs" Inherits="WebPage.Cart" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="StyleSheet1.css" rel="stylesheet" />
</head>
<body>
    <div class="center">
        <form id="form1" runat="server">

        <div>
            <asp:Button ID="Button2" runat="server" Text="&lt; Continue shopping" OnClick="Button2_Click" /><br /><br />
            <asp:GridView ID="GridView1" runat="server">
            </asp:GridView>
            <br />
            <asp:Label ID="msg" runat="server"></asp:Label>
            <br />
            <asp:Label ID="Label1" runat="server"></asp:Label>
            <br />
            <asp:Label ID="Label2" runat="server"></asp:Label><br />
            <asp:Label ID="Label3" runat="server"></asp:Label>
            <br />
            <div style="text-align:center"><asp:Button ID="Button1" runat="server" Text="Buy" OnClick="Button1_Click" /></div>
            <br />
        </div>
    </form>
    </div>
    
</body>
</html>

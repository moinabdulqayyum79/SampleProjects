<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="ProductDetail.aspx.cs" Inherits="WebPage.ProductDetail" %>

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
                <asp:Button ID="Button2" runat="server" Text="&lt; Back" OnClick="Button2_Click" /><br /><br />
                <asp:Label ID="Label1" runat="server" Text="Product Name: " Font-Bold="true"></asp:Label>
                <asp:Label ID="prodName" runat="server" Text="aa"></asp:Label><br />
                <asp:Label ID="Label2" runat="server" Text="Category: " Font-Bold="true"></asp:Label>
                <asp:Label ID="category" runat="server" Text=""></asp:Label><br />
                <asp:Label ID="Label3" runat="server" Text="Brand: " Font-Bold="true"></asp:Label>
                <asp:Label ID="brand" runat="server" Text=""></asp:Label><br />
                <asp:Label ID="Label4" runat="server" Text="Price: " Font-Bold="true"></asp:Label>
                <asp:Label ID="price" runat="server" Text=""></asp:Label><br />
                <asp:Label ID="Label5" runat="server" Text="Description: " Font-Bold="true"></asp:Label>
                <asp:Label ID="description"  runat="server" Text="" ></asp:Label><br />
                <br /><asp:Label ID="Label6" runat="server" Text="Quantity: "></asp:Label>
                <asp:TextBox ID="TextBox1" runat="server"></asp:TextBox>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="TextBox1" ErrorMessage="Must enter Quantity"></asp:RequiredFieldValidator>
                <br />
                <br />
                <div style="text-align:center"><asp:Button ID="Button1" runat="server" Text="Add to Cart" OnClick="Button1_Click" /></div>
            </div>
        </form>
    </div>
    
</body>
</html>

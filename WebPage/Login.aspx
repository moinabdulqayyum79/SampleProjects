<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Login.aspx.cs" Inherits="WebPage.Login" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="StyleSheet1.css" rel="stylesheet" />
</head>
<body>
    <div class="center">
        <form id="form1" runat="server">
        
            <asp:Label ID="Label3" runat="server"></asp:Label><br /><br />
        
            <asp:Label ID="Label1" runat="server" Text="Email: "></asp:Label>
            <asp:TextBox ID="emailtxt" runat="server"></asp:TextBox> 
            <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="emailtxt" ErrorMessage="Please enter Email"></asp:RequiredFieldValidator>
            <br /><br />
            <asp:Label ID="Label2" runat="server" Text="Password: "></asp:Label>
            <asp:TextBox ID="passwordtxt" runat="server" TextMode="Password"></asp:TextBox>
            <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ControlToValidate="passwordtxt" ErrorMessage="Please enter Password"></asp:RequiredFieldValidator>
            <br /><br />
            <div style="text-align:center">
                <asp:Button ID="Button1" runat="server" Text="Login" OnClick="Button1_Click" /><br />
                <asp:Label ID="Message" runat="server"></asp:Label>
            </div>
        </form>
    </div>
</body>
</html>

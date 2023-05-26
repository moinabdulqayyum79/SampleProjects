<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Register.aspx.cs" Inherits="WebPage.Register" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="StyleSheet1.css" rel="stylesheet" />
</head>
<body>
    <div class="center">
         <form id="form1" runat="server">
        
            <asp:Label ID="Label3" runat="server" Text="First Name: "></asp:Label>
            <asp:TextBox ID="FNametxt" runat="server"></asp:TextBox>
            <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ControlToValidate="FNametxt" ErrorMessage="Must enter First Name"></asp:RequiredFieldValidator>
            <br />
                <br />
            <asp:Label ID="Label4" runat="server" Text="Last Name: "></asp:Label>
            <asp:TextBox ID="LNametxt" runat="server"></asp:TextBox>
            <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" ControlToValidate="LNametxt" ErrorMessage="Must enter Last Name"></asp:RequiredFieldValidator>
            <br />
                <br />
            <asp:Label ID="Label5" runat="server" Text="Email: "></asp:Label>
            <asp:TextBox ID="Emailtxt" runat="server"></asp:TextBox>
            <asp:RequiredFieldValidator ID="RequiredFieldValidator4" runat="server" ControlToValidate="Emailtxt" ErrorMessage="Must enter Email"></asp:RequiredFieldValidator>
            <asp:RegularExpressionValidator ID="RegularExpressionValidator1" runat="server" ControlToValidate="Emailtxt" ErrorMessage="Enter valid Email" ValidationExpression="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"></asp:RegularExpressionValidator>
            <br />
                <br />
            <asp:Label ID="Label6" runat="server" Text="Password: "></asp:Label>
            <asp:TextBox ID="Passwordtxt" runat="server" TextMode="Password"></asp:TextBox> 
            <asp:RequiredFieldValidator ID="RequiredFieldValidator5" runat="server" ControlToValidate="Passwordtxt" ErrorMessage="Must enter Password"></asp:RequiredFieldValidator>
            <br />
            <br />
                <br />
            <div style="text-align:center">
                <asp:Button ID="Button1" runat="server" Text="Register" OnClick="Button1_Click" /><br />
                <asp:Label ID="Message" runat="server" Text=""></asp:Label><br />
                <br /><asp:Label ID="Label7" runat="server" Text="Already have an account: "></asp:Label>
                <asp:Button ID="Button2" runat="server" Height="28px" OnClick="Button2_Click" Text="Login" CausesValidation="False" />
            </div>
        
        
        </form>
    </div>
       
    
</body>
</html>

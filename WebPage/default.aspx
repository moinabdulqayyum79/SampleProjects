<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="default.aspx.cs" Inherits="WebPage.Choose" %>

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
                <asp:Button ID="Register" runat="server" OnClick="Register_Click" Text="Register" Width="125px" />
            </div>
            
                
                <div style="text-align:center">
                    <br />
                    <asp:Label ID="Label1" runat="server" Text="Or"></asp:Label></div>
            
            <br />
            
            <asp:Button ID="Login" runat="server" OnClick="Login_Click" Text="Login" Width="125px" />
        </form>
    </div>
        
</body>
</html>

using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Data.SqlClient;
using System.Threading;

namespace WebPage
{
    
    public partial class Login : System.Web.UI.Page
    {

        SqlConnection conn = new SqlConnection(System.Configuration.ConfigurationManager.ConnectionStrings["WebPageDBConnectionString"].ConnectionString);
        public static string fname;
        public static string lname;
        public static int userId;
        protected void Button1_Click(object sender, EventArgs e)
        {
            string query = "select * from Users where Email=@email and Password=@password";
            string email = emailtxt.Text;
            string password = passwordtxt.Text;
            try
            {
                
                SqlCommand cmnd = new SqlCommand(query, conn);
                cmnd.Parameters.AddWithValue("@email", email);
                cmnd.Parameters.AddWithValue("@password", password);
                conn.Open();
                SqlDataReader sdr = cmnd.ExecuteReader();
                if (sdr.Read())
                {
                    userId = Convert.ToInt32(sdr[0]);
                    fname = sdr[1].ToString();
                    lname = sdr[2].ToString();
                    Message.Text = "Login Successful";
                   
                    Response.Redirect("HomePage.aspx");
                    
                    
                }
                else
                {
                    Message.Text = "Invalid email or password";
                }
            }
            catch(Exception ex)
            {
                Message.Text = ex.Message;
            }
            finally
            {
                conn.Close();
            }
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Register.registered)
            {
                Label3.Text = "Registration complete. Please Login again";
            }
        }
    }
}
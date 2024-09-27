package org.example;

import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;

@WebServlet(name = "HelloServlet", urlPatterns = {"/insert"})
public class HelloServlet extends HttpServlet {
    // PostgreSQL credentials
    private static final String DB_URL = "jdbc:postgresql://autorack.proxy.rlwy.net:11583/railway";
    private static final String DB_USER = "postgres";
    private static final String DB_PASSWORD = "DTBxoOTdGEtauzYrXUDIAAgkOZXYVxoG";

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Set response content type
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        // Get form data (from a POST request)
        String firstName = request.getParameter("firstName");
        String lastName = request.getParameter("lastName");

        // Insert data into the database
        Connection conn = null;
        PreparedStatement stmt = null;

        try {
            // Load the PostgreSQL driver
            Class.forName("org.postgresql.Driver");

            // Establish the connection
            conn = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);

            // Create SQL query
            String sql = "INSERT INTO students (fname, lname) VALUES (?, ?)";

            // Create a prepared statement
            stmt = conn.prepareStatement(sql);
            stmt.setString(1, firstName);
            stmt.setString(2, lastName);

            // Execute the query
            int rowsInserted = stmt.executeUpdate();

            // Provide feedback
            if (rowsInserted > 0) {
                out.println("<h1>Data successfully inserted!</h1>");
            } else {
                out.println("<h1>Failed to insert data.</h1>");
            }

        } catch (SQLException | ClassNotFoundException e) {
            e.printStackTrace();
            out.println("<h1>Error: " + e.getMessage() + "</h1>");
        } finally {
            // Close resources
            try {
                if (stmt != null) stmt.close();
                if (conn != null) conn.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // If GET request, display a form for data entry
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();
        
        out.println("<html><body>");
        out.println("<h1>Insert Data</h1>");
        out.println("<form action='insert' method='post'>");
        out.println("First Name: <input type='text' name='firstName'><br>");
        out.println("Last Name: <input type='text' name='lastName'><br>");
        out.println("<input type='submit' value='Insert'>");
        out.println("</form>");
        out.println("</body></html>");
    }
}

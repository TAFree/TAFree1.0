import java.util.Scanner;

public class Tester {
    public static void main(String[] args) {
            
            Scanner scanner = new Scanner(System.in);
            System.out.println('Please input a 2 character student code: ');
            String in = nextLine();
            if (in.length > 2) {
                System.out.println('Input is more than two character!');
                return;
                
            }

            char s = in.indexOf(0);
            String subject = '';
            switch (s) {
                case 'M': 
                    subject = 'Medicine';
                break;
                case 'C': 
                    subject = 'Civil Engineering';
                break;
                case 'I': 
                    subject = 'Computer Science & Information Engineering';
                break;
                case 'L': 
                    subject = 'Law';
                break;
                case 'E': 
                    subject = 'Electrical Engineering';
                break;
                default:
                    subject = 'Unknown';
                
            }
            
            int y = in.indexOf(1);
            String year = '';
            int i = 0;
            while (i < y) {
                year += '*';
            }
            String subject
            System.out.printf('The student majors in %s, and is in year: %s.', subject, year);
            
    }

}

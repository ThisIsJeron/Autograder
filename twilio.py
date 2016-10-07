# Download the twilio-python library from http://twilio.com/docs/libraries
from twilio.rest import TwilioRestClient
 
# Find these values at https://twilio.com/user/account
account_sid = "ACa2c293449cb04276aa45cdd8ac130342"
auth_token = "Yed115b94915402b317ff74151b981198"
client = TwilioRestClient(account_sid, auth_token)
 
message = client.messages.create(to="+14088217529", from_="+14085603576",
                                     body="Hello there!")

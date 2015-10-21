# Public Slack
This is a simple PHP page that you can direct people to sign up for your Slack group, without you needing to personally send out invites.

[Here is an example](http://lifeformed.org/publicSlack/) of what the page looks like.

## Setup
You need to find your Slack authentication token for sending invites.  Here is how to find it:

1. Sign into your Slack group as an Administrator.
2. Go to your team invitation page: https://example.slack.com/admin/invites
3. Open up the developer tools in your browser, and select the Network tab.
4. Invite a member.  You can enter a fake address.
5. In the developer tools, find the request that looks like `users.admin.invite?t=1111111111`
6. Scroll down to the bottom of the request and find the Form Data.  Write down the information in the **channels** and **token** fields.
7. In the `config.php` file, enter the information you wrote down in step 6.  Set `slackAutoJoinChannels` to the **channels** field, and `slackAuthToken` to the **token** field.
8. Also put your Slack group name under `slackHostName`.  It should be the same as group name in your Slack URL.
9. Set the contact information, which will be used in the signup page if people are having troubles.
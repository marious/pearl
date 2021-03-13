{{ header }}

<table width="100%">
    <tbody>
        <tr>
            <td class="wrapper" width="700" align="center">
                <table class="section" cellpadding="0" cellspacing="0" width="700" bgcolor="#f8f8f8">
                    <tr>
                        <td class="column" align="left">
                            <table>
                                <tbody>
                                <tr>
                                    <td align="left" style="padding: 20px 50px;">
                                        <p><strong>هناك رسالة حجز جديد من الموقع:</strong></p>
                                        <p><img src="{{ site_url }}/vendor/core/core/base/images/emails/person.png"
                                                alt="From" width="20" style="margin-right: 10px;" /> {{ Name }}</p>
                                        <p><img src="{{ site_url }}/vendor/core/core/base/images/emails/edit.png"
                                                alt="Subject" width="20" style="margin-right: 10px;" /> {{ Department }}</p>
                                        <p><img src="{{ site_url }}/vendor/core/core/base/images/emails/email.png"
                                                alt="Email" width="20" style="margin-right: 10px;" /> {{ Email }}</p>
                                        <p><img src="{{ site_url }}/vendor/core/core/base/images/emails/phone.png"
                                                alt="Phone" width="20" style="margin-right: 10px;" /> {{ Phone }}</p>
                                        <p><img src="{{ site_url }}/vendor/core/core/base/images/emails/message.png"
                                                alt="Message" width="20" style="margin-right: 10px;" /> {{ message }}</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td class="wrapper" width="700" align="center">
                <table class="section main" cellpadding="0" cellspacing="0" width="700">
                    <tr>
                        <td class="column" align="center">
                            <table>
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <p>You can reply an email to {{ email }} by clicking on below button.</p> <br />
                                        <a href="mailto:{{ email }}" class="action-button">Answer</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
{{ footer }}

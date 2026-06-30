# Infrastructure Notes

## Overview

The `timfetter.com` infrastructure uses separate services for hosting, email hosting, transactional email, and the daily email client.

| Service    | Responsibility                                         |
| ---------- | ------------------------------------------------------ |
| Hover      | Domain registrar only                                  |
| SiteGround | Website hosting, authoritative DNS, email hosting      |
| Brevo      | Transactional email sent by WordPress                  |
| FluentSMTP | Connects WordPress to Brevo                            |
| Gmail      | Daily email client (receives and sends business email) |
| Forminator | Contact form plugin                                    |

---

# Domain and DNS

## Domain

- Domain: `timfetter.com`
- Registrar: Hover

## Authoritative DNS

DNS is managed by **SiteGround**, not Hover.

Nameservers:

```
ns1.siteground.net
ns2.siteground.net
```

Verify:

```bash
dig NS timfetter.com
```

Expected:

```
ns1.siteground.net
ns2.siteground.net
```

**Important**

Once SiteGround nameservers became authoritative during the migration, every DNS record at Hover stopped being used.

Any future DNS changes (Brevo, Google, MX, TXT, etc.) must be made in:

```
SiteGround
→ Site Tools
→ DNS Zone Editor
```

---

# Hosting

Website host:

- SiteGround

Site files, DNS, databases and email accounts are all managed through SiteGround.

---

# Email Architecture

There are **three completely separate email flows**.

## 1. Website Contact Form

```
Visitor

↓

Forminator

↓

FluentSMTP

↓

Brevo API

↓

Recipient (Gmail)
```

Purpose:

- Contact form notifications
- WordPress transactional email

Brevo is responsible only for **website-generated email**.

---

## 2. Direct Business Email

```
Internet

↓

contact@timfetter.com
(SiteGround mailbox)

↓

POP3

↓

Gmail Inbox
```

Purpose:

- Direct emails sent to the business address

SiteGround hosts the mailbox.

Gmail simply checks the mailbox via POP3.

---

## 3. Outbound Business Replies

```
Gmail

↓

SiteGround SMTP

↓

Recipient
```

Purpose:

- Replies to inquiries
- New business emails

Messages are composed in Gmail but sent through SiteGround SMTP.

---

# WordPress Email Sending

WordPress uses:

- FluentSMTP
- Brevo API

Configured sender:

```
From:
contact@timfetter.com

Name:
Tim Fetter
```

Used for:

- Forminator notifications
- WordPress transactional mail
- SMTP testing

Form submissions are still stored inside WordPress even if email delivery fails.

Check submissions:

```
WordPress Admin

→ Forminator

→ Submissions
```

Check email logs:

```
WordPress Admin

→ FluentSMTP

→ Email Logs
```

---

# Brevo

Brevo is used exclusively for WordPress transactional email.

Configuration:

- Provider: Brevo
- Connection: FluentSMTP API
- Authentication: API Key

Never commit API keys to Git.

Logs:

```
Brevo

→ Transactional

→ Logs
```

A successful contact form submission should appear in:

- FluentSMTP logs
- Brevo logs

---

# Brevo DNS Authentication

These records exist in SiteGround DNS.

## TXT Verification

```
Type:
TXT

Host:
@

Value:
brevo-code:7b969bed672aab2f1c297c3c5f62a1ec
```

## DKIM

```
Type:
CNAME

Host:
brevo1._domainkey

Value:
b1.timfetter-com.dkim.brevo.com
```

```
Type:
CNAME

Host:
brevo2._domainkey

Value:
b2.timfetter-com.dkim.brevo.com
```

## DMARC

```
Type:
TXT

Host:
_dmarc

Value:
v=DMARC1; p=none; aspf=r; adkim=r; rua=mailto:rua@dmarc.brevo.com
```

There should only be **one** DMARC record.

Verify:

```bash
dig TXT _dmarc.timfetter.com
```

---

# SiteGround Email

Mailbox:

```
contact@timfetter.com
```

Hosted by:

SiteGround

Inbound mail is handled using SiteGround's **System Default MX Records**.

Enable them using:

```
SiteGround

→ DNS Zone Editor

→ MX

→ Switch to System Default MX Records
```

Expected MX records:

```bash
dig MX timfetter.com
```

Expected:

```
10 mx10.antispam.mailspamprotection.com

20 mx20.antispam.mailspamprotection.com

30 mx30.antispam.mailspamprotection.com
```

The old configuration:

```
MX 0 timfetter.com
```

caused inbound delivery failures.

---

# Gmail Integration

Gmail is used as the daily email client.

## Receiving Mail

Gmail imports mail using POP3.

Settings:

```
Settings

→ Accounts and Import

→ Check mail from other accounts
```

Account:

```
contact@timfetter.com
```

POP Server:

```
mail.timfetter.com
```

Port:

```
110
```

Username:

```
contact@timfetter.com
```

Password:

```
SiteGround mailbox password
```

Result:

Business email appears directly inside Gmail.

---

## Sending Mail

Gmail is configured to send mail through SiteGround SMTP.

Settings:

```
Settings

→ Accounts and Import

→ Send mail as
```

Identity:

```
Tim Fetter

contact@timfetter.com
```

SMTP Server:

```
mail.timfetter.com
```

Port:

```
465
```

Encryption:

```
SSL
```

Username:

```
contact@timfetter.com
```

Password:

```
SiteGround mailbox password
```

Gmail successfully verified ownership after inbound mail delivery was restored.

---

## Gmail Reply Behavior

Current Gmail setting:

```
Reply from the same address the message was sent to
```

Important:

Contact form notifications are delivered to the Gmail account rather than directly to `contact@timfetter.com`.

Because of this, Gmail may choose:

```
tim.fetter.mail@gmail.com
```

when replying.

Before sending replies to contact form inquiries, verify the From field is:

```
Tim Fetter <contact@timfetter.com>
```

Gmail remembers recently selected identities.

If preferred, `contact@timfetter.com` can be made the default sender.

---

# Forminator Notification Settings

Recommended notification:

```
To:

timfettermail@gmail.com

From:

contact@timfetter.com

Reply-To:

{email-1}
```

Never use the visitor's email address as the From address.

Correct pattern:

```
From:
Tim Fetter <contact@timfetter.com>

Reply-To:
visitor@example.com
```

---

# Troubleshooting

## Contact Form

1. Check Forminator submissions.

2. Check FluentSMTP logs.

3. Check Brevo logs.

4. Search Gmail:

```
from:contact@timfetter.com newer_than:1d

subject:"New portfolio contact form submission"
```

---

## Brevo Authentication

Verify:

```bash
dig NS timfetter.com

dig TXT timfetter.com

dig TXT _dmarc.timfetter.com

dig CNAME brevo1._domainkey.timfetter.com

dig CNAME brevo2._domainkey.timfetter.com
```

---

## MX Records

Verify:

```bash
dig MX timfetter.com
```

Expected:

```
mx10.antispam.mailspamprotection.com

mx20.antispam.mailspamprotection.com

mx30.antispam.mailspamprotection.com
```

---

## Gmail Replies Use Gmail Address

This is expected.

Because the notification was delivered to the Gmail account, Gmail may default replies to:

```
tim.fetter.mail@gmail.com
```

Before sending, choose:

```
From:

Tim Fetter <contact@timfetter.com>
```

Alternatively:

```
Settings

→ Accounts and Import

→ Make contact@timfetter.com the default sender
```

---

# Current Working Configuration (June 2026)

✓ Domain registered with Hover

✓ DNS hosted by SiteGround

✓ Website hosted by SiteGround

✓ SiteGround mailbox:
`contact@timfetter.com`

✓ Gmail retrieves mail using POP3

✓ Gmail sends through SiteGround SMTP

✓ WordPress sends through Brevo API

✓ FluentSMTP configured with Brevo

✓ Forminator notifications delivered successfully

✓ SPF passing

✓ DKIM passing

✓ DMARC passing

Verified using:

- FluentSMTP Email Logs
- Brevo Transactional Logs
- Gmail delivery tests

---

# Lessons Learned (June 2026 Migration)

Changing the authoritative nameservers from Hover to SiteGround meant that every DNS record at Hover immediately became irrelevant.

Brevo authentication initially failed because its TXT, DKIM and DMARC records existed only at Hover. Recreating those records in SiteGround resolved domain authentication.

Inbound email initially failed because the domain was still using the legacy MX record:

```
MX 0 timfetter.com
```

Switching to SiteGround's **System Default MX Records** restored mail delivery.

FluentSMTP had to be reinstalled after the migration and reconnected to Brevo using the API key.

The final architecture separates responsibilities cleanly:

- **SiteGround** hosts the website, DNS and mailbox.
- **Brevo** sends website-generated transactional email.
- **Gmail** serves as the interface for reading and sending business email.
